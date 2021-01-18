<?php

namespace Thtg88\MmCms\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Thtg88\MmCms\Http\Requests\Auth\LoginRequest;
use Thtg88\MmCms\Http\Requests\Auth\LogoutRequest;
use Thtg88\MmCms\Http\Requests\Auth\RegisterRequest;
use Thtg88\MmCms\Http\Requests\Auth\TokenRequest;
use Thtg88\MmCms\Http\Requests\Auth\UpdateProfileRequest;
use Thtg88\MmCms\Http\Resources\UserResource;
use Thtg88\MmCms\Repositories\OauthRefreshTokenRepository;
use Thtg88\MmCms\Repositories\RoleRepository;
use Thtg88\MmCms\Repositories\UserRepository;

class AuthController extends Controller
{
    /**
     * The OAuth refresh tokens repository implementation.
     *
     * @var \Thtg88\MmCms\Repositories\OauthRefreshTokenRepository
     */
    protected $oauth_refresh_tokens;

    /**
     * The repository implementation.
     *
     * @var \Thtg88\MmCms\Repositories\UserRepository
     */
    protected $repository;

    /**
     * The role repository implementation.
     *
     * @var \Thtg88\MmCms\Repositories\RoleRepository
     */
    protected $roles;

    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Repositories\UserRepository              $repository
     * @param \Thtg88\MmCms\Repositories\OauthRefreshTokenRepository $oauth_refresh_tokens
     * @param \Thtg88\MmCms\Repositories\RoleRepository              $roles
     *
     * @return void
     */
    public function __construct(
        UserRepository $repository,
        OauthRefreshTokenRepository $oauth_refresh_tokens,
        RoleRepository $roles
    ) {
        $this->repository = $repository;
        $this->oauth_refresh_tokens = $oauth_refresh_tokens;
        $this->roles = $roles;
    }

    /**
     * Register a new user.
     *
     * @param \Thtg88\MmCms\Http\Requests\Auth\RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        // Get input
        $input = $request->except([
            'created_at',
            'deleted_at',
            'role_id',
            'updated_at',
        ]);

        // Get a random user to see if there is any
        $random_user = $this->repository->findRandom();
        if ($random_user === null) {
            // If not found it means the first one is registering

            // Get developer role
            $developer_role = $this->roles->findByModelName(
                Config::get('mmcms.roles.names.developer')
            );
            if ($developer_role !== null) {
                // If found - assign it to the user registering
                $input['role_id'] = $developer_role->id;
            }
        }

        if (!array_key_exists('role_id', $input)) {
            // Get user role
            $user_role = $this->roles->findByModelName(
                Config::get('mmcms.roles.names.user')
            );

            if ($user_role !== null) {
                // If found - assign it to the user registering
                $input['role_id'] = $user_role->id;
            }
        }

        // Create user
        $user = $this->repository->create($input)->load(['role']);

        $oauth_data = $this->getOauthAccessTokenData(
            $request->get('email'),
            $request->get('password'),
            $request->server('SERVER_NAME')
        );

        try {
            // Request OAuth token
            $response = app('OauthHttpClient')->post(
                '/v1/oauth/token',
                $oauth_data
            );

            // Get response
            // $response->getBody() is a stream
            // by casting it to string we force it to return the content
            // this behaviour is expected and documented by Guzzle
            // http://docs.guzzlephp.org/en/stable/quickstart.html#using-responses
            $response_data = json_decode((string) $response->getBody(), true);
            $response_data['resource'] = new UserResource($user);
        } catch (\Exception $e) {
            // If there was an error registering the user
            // Delete the newly created user
            // and send the error response to the client
            $this->repository->destroy($user->id);

            return response()->json([
                'errors' => [
                    'invalid_credentials' => $e->getCode().': '.
                        $e->getMessage(),
                ],
                'message' => 'The user credentials were incorrect.',
            ], 401);
        }

        Container::getInstance()->make('events', [])
            ->dispatch(new Registered($user));

        return response()->json($response_data);
    }

    /**
     * Login a user.
     *
     * @param \Thtg88\MmCms\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $oauth_data = $this->getOauthAccessTokenData(
            $request->get('email'),
            $request->get('password'),
            $request->server('SERVER_NAME')
        );

        try {
            // Request OAuth token
            $response = app('OauthHttpClient')->post(
                '/v1/oauth/token',
                $oauth_data
            );

            // Get response
            // $response->getBody() is a stream
            // by casting it to string we force it to return the content
            // this behaviour is expected and documented by Guzzle
            // http://docs.guzzlephp.org/en/stable/quickstart.html#using-responses
            $response_data = json_decode((string) $response->getBody(), true);
        } catch (Exception $e) {
            return response()->json([
                'errors' => [
                    'invalid_credentials' => $e->getCode().': '.$e->getMessage(),
                ],
                'message' => 'The user credentials were incorrect.',
            ], 401);
        }

        return response()->json($response_data);
    }

    /**
     * Logout a user.
     *
     * @param \Thtg88\MmCms\Http\Requests\Auth\LogoutRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(LogoutRequest $request)
    {
        // Get access token
        $access_token = $request->user()->token();

        // Revoke access token
        $this->oauth_refresh_tokens->update($access_token->id, [
            'revoked' => true,
        ]);

        $access_token->revoke();

        return response()->json(['success' => true], 201);
    }

    /**
     * Return the current user data.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return response()->json([
            'resource' => new UserResource($request->user()->load(['role'])),
        ]);
    }

    /**
     * Refresh token.
     *
     * @param \Thtg88\MmCms\Http\Requests\Auth\TokenRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function token(TokenRequest $request)
    {
        $oauth_data = [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'client_id'  => Config::get(
                    'mmcms.passport.password_client_id'
                ),
                'client_secret' => Config::get(
                    'mmcms.passport.password_client_secret'
                ),
                'refresh_token' => $request->get('refresh_token'),
                'scope'         => '',
            ],
            'headers' => [
                // This allows loopback on custom localhost domains
                'Host' => $request->server('SERVER_NAME'),
            ],
        ];

        try {
            // Request OAuth token
            $response = app('OauthHttpClient')->post(
                '/v1/oauth/token',
                $oauth_data
            );

            // Get response
            // $response->getBody() is a stream
            // by casting it to string we force it to return the content
            // this behaviour is expected and documented by Guzzle
            // http://docs.guzzlephp.org/en/stable/quickstart.html#using-responses
            $response_data = json_decode((string) $response->getBody(), true);
            $response_status_code = 200;
        } catch (\Exception $e) {
            $response_data = [
                'errors' => [
                    'invalid_credentials' => $e->getCode().': '.$e->getMessage(),
                ],
                'message' => 'The user credentials were incorrect.',
            ];

            $response_status_code = 401;
        }

        return response()->json($response_data, $response_status_code);
    }

    /**
     * Update the current user data.
     *
     * @param \Thtg88\MmCms\Http\Requests\Auth\UpdateProfileRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        // Get user
        $user = $request->user()->load(['role']);

        // Get input
        $input = $request->all();

        // Get admin role
        $admin_role = $this->roles->findByModelName(
            Config::get('mmcms.roles.names.user')
        );

        $except = [
            'created_at',
            'deleted_at',
        ];

        if (
            $user->role === null ||
            $admin_role === null ||
            $user->role->priority > $admin_role->priority
        ) {
            if (array_key_exists('role_id', $input)) {
                // Remove role_id from editable fields if user less then admin
                $except[] = 'role_id';
            }
        }

        // Get input
        $input = $request->except($except);

        // Update user
        $user = $this->repository->update($user->id, $input);

        return response()->json(['resource' => new UserResource($user)]);
    }

    /**
     * Return the data for the OAuth access token request data.
     *
     * @param string $email
     * @param string $password
     * @param string $server_name
     *
     * @return array
     */
    protected function getOauthAccessTokenData(
        string $email,
        string $password,
        string $server_name
    ): array {
        return [
            'form_params' => [
                'grant_type' => 'password',
                'client_id'  => Config::get(
                    'mmcms.passport.password_client_id'
                ),
                'client_secret' => Config::get(
                    'mmcms.passport.password_client_secret'
                ),
                'username' => $email,
                'password' => $password,
                'remember' => false,
                'scope'    => '',
            ],
            // This allows loopback on custom localhost domains
            'headers' => ['Host' => $server_name],
        ];
    }
}
