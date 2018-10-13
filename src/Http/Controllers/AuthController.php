<?php

namespace Thtg88\MmCms\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
// Controllers
use Thtg88\MmCms\Http\Controllers\Controller;
// Requests
use Thtg88\MmCms\Http\Requests\Auth\LoginRequest;
use Thtg88\MmCms\Http\Requests\Auth\LogoutRequest;
use Thtg88\MmCms\Http\Requests\Auth\RegisterRequest;
use Thtg88\MmCms\Http\Requests\Auth\UpdateProfileRequest;
// Repositories
use Thtg88\MmCms\Repositories\OauthRefreshTokenRepository;
use Thtg88\MmCms\Repositories\RoleRepository;
use Thtg88\MmCms\Repositories\UserRepository;

class AuthController extends Controller
{
    /**
     * The HTTP client implementation.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http_client;

    /**
     * The OAuth refresh tokens repository implementation.
     *
     * @var \Thtg88\MmCms\Repositories\OauthRefreshTokenRepository
     */
    protected $oauth_refresh_tokens;

    /**
     * The role repository implementation.
     *
     * @var \Thtg88\MmCms\Repositories\RoleRepository
     */
    protected $roles;

    /**
     * Create a new controller instance.
     *
     * @param       \Thtg88\MmCms\Repositories\UserRepository        $users
     * @param       \Thtg88\MmCms\Repositories\OauthRefreshTokenRepository   $oauth_refresh_tokens
     * @param       \Thtg88\MmCms\Repositories\RoleRepository   $roles
     * @return      void
     */
    public function __construct(
        UserRepository $users,
        OauthRefreshTokenRepository $oauth_refresh_tokens,
        RoleRepository $roles
    )
    {
        $this->repository = $users;
        $this->oauth_refresh_tokens = $oauth_refresh_tokens;
        $this->roles = $roles;

        $this->http_client = new Client([
            'verify' => config('app.env') !== 'local'
        ]);
    }

    /**
     * Register a new user.
     *
     * @param  \Thtg88\MmCms\Http\Requests\Auth\RegisterRequest  $request
     * @return \Illuminate\Http\Response
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

        if(array_key_exists('password', $input))
        {
            $input['password'] = bcrypt($input['password']);
        }

        // Get a random user to see if there is any
        $random_user = $this->repository->findRandom();
        if ($random_user === null)
        {
            // If not found it means the first one is registering

            // Get developer role
            $developer_role = $this->roles->findByModelName(config('mmcms.roles.developer_role_name'));
            if($developer_role !== null)
            {
                // If found - assign it to the user registering
                $input['role_id'] = $developer_role->id;
            }
        }

        if(!array_key_exists('role_id', $input))
        {
            // Get user role
            $user_role = $this->roles->findByModelName(config('mmcms.roles.user_role_name'));

            if($user_role !== null)
            {
                // If found - assign it to the user registering
                $input['role_id'] = $user_role->id;
            }
        }

        // Create user
        $user = $this->repository->create($input);

        try
        {
            event(new Registered($user));

            $oauth_data = [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('mmcms.passport.password_client_id'),
                    'client_secret' => config('mmcms.passport.password_client_secret'),
                    'username' => $request->get('email'),
                    'password' => $request->get('password'),
                    'remember' => false,
                    'scope' => '',
                ],
                'headers' => [
                    // This allows loopback on custom localhost domains
                    'Host' => $request->server('SERVER_NAME'),
                ]
            ];

            // Request OAuth token
            $response = $this->http_client->post(config('mmcms.passport.oauth_url').'/oauth/token', $oauth_data);

            // Get response
            // $response->getBody() is a stream
            // by casting it to string we force it to return the content
            // this behaviour is expected and documented by Guzzle
            // http://docs.guzzlephp.org/en/stable/quickstart.html#using-responses
            $response_data = json_decode((string)$response->getBody(), true);
            $response_data['resource'] = $user;
            $response_status_code = 200;
        }
        catch (\Exception $e)
        {
            // If there was an error registering the user
            // Delete the newly created user
            // and send the error response to the client
            $this->repository->destroy($user->id);

            $response_data = [
                'errors' => [
                    'invalid_credentials' => $e->getCode().': '.$e->getMessage(),
                ],
                'message' => 'The user credentials were incorrect.'
            ];

            $response_status_code = 401;
        }

        return response()->json($response_data, $response_status_code);
    }

    /**
     * Login a user.
     *
     * @param  \Thtg88\MmCms\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        try
        {
            $oauth_data = [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('mmcms.passport.password_client_id'),
                    'client_secret' => config('mmcms.passport.password_client_secret'),
                    'username' => $request->get('email'),
                    'password' => $request->get('password'),
                    'remember' => $request->get('remember'),
                    'scope' => '',
                ],
                'headers' => [
                    // This allows loopback on custom localhost domains
                    'Host' => $request->server('SERVER_NAME'),
                ]
            ];

            // Request OAuth token
            $response = $this->http_client->post(config('mmcms.passport.oauth_url').'/oauth/token', $oauth_data);

            // Get response
            // $response->getBody() is a stream
            // by casting it to string we force it to return the content
            // this behaviour is expected and documented by Guzzle
            // http://docs.guzzlephp.org/en/stable/quickstart.html#using-responses
            $response_data = json_decode((string)$response->getBody(), true);
            $response_status_code = 200;
        }
        catch (\Exception $e)
        {
            $response_data = [
                'errors' => [
                    'invalid_credentials' => $e->getCode().': '.$e->getMessage(),
                ],
                'message' => 'The user credentials were incorrect.'
            ];

            $response_status_code = 401;
        }

        return response()->json($response_data, $response_status_code);
    }

    /**
     * Logout a user.
     *
     * @param  \Thtg88\MmCms\Http\Requests\Auth\LogoutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(LogoutRequest $request)
    {
        // Get access token
        $access_token = $request->user()->token();

        $data = [
            'revoked' => true,
        ];

        // Revoke access token
        $this->oauth_refresh_tokens->update($access_token->id, $data);

        $access_token->revoke();

        $response_data = [
            'success' => true
        ];

        return response()->json($response_data, 201);
    }

    /**
     * Return the current user data.
     *
     * @param   \Illuminate\Http\Request        $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return response()->json(['resource' => $request->user(), ]);
    }

    /**
     * Update the current user data.
     *
     * @param   \Thtg88\MmCms\Http\Requests\Auth\UpdateProfileRequest        $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        // Get user
        $user = $request->user();

        // Get input
        $input = $request->all();

        // Get admin role
        $admin_role = $this->roles->findByModelName(config('mmcms.roles.user_role_name'));

        $except = [
            'created_at',
            'deleted_at',
        ];

        if($user->role === null || $admin_role === null || $user->role->priority > $admin_role->priority)
        {
            if(array_key_exists('role_id', $input))
            {
                // Remove role_id from editable fields if user less then admin
                $except = 'role_id';
            }
        }

        // Get input
        $input = $request->except($except);

        // Update user
        $user = $this->repository->update($user->id, $input);

        return response()->json(['resource' => $user, ]);
    }
}
