<?php

namespace Thtg88\MmCms\Http\Controllers;

use Laravel\Passport\Exceptions\OAuthServerException;
use Laravel\Passport\Http\Controllers\AccessTokenController as BaseAccessTokenController;
use Nyholm\Psr7\Response as Psr7Response;
use Psr\Http\Message\ServerRequestInterface;

class AccessTokenController extends BaseAccessTokenController
{
    /**
     * Authorize a client to access the user's account.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Illuminate\Http\Response
     */
    public function issueToken(ServerRequestInterface $request)
    {
        // When trying to login with incorrect password,
        // OAuth2 Server returns an exception containing the following message:
        // > The provided authorization grant (e.g., authorization code, resource owner credentials)
        // > or refresh token is invalid, expired, revoked,
        // > does not match the redirection URI used in the authorization request,
        // > or was issued to another client.
        // As this gets logged in Bugsnag as an error,
        // And it's pretty meaningless to mobile app users
        // getting their password wrong, we intercept its code (10),
        // which is only used in this kind of situation anyway
        // and we convert the response to an auth.failed one.
        // See original Laravel Passport issue at:
        // https://github.com/laravel/passport/issues/1113
        try {
            $response = $this->withErrorHandling(function () use ($request) {
                return $this->convertResponse(
                    $this->server->respondToAccessTokenRequest($request, new Psr7Response())
                );
            });
        } catch (OAuthServerException $e) {
            if ($e->getCode() === 10) {
                return response()->json([
                    'errors'  => [__('auth.failed')],
                    'message' => __('auth.failed'),
                ], 401);
            }

            throw $e;
        }

        return $response;
    }
}
