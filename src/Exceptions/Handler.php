<?php

namespace Thtg88\MmCms\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     *
     * @throws \Exception
     *
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $exception
     *
     * @throws \Throwable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            return $this->renderJson($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $exception
     *
     * @throws \Throwable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderJson($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            $msg = $exception->getMessage() ?: 'Resource not found.';

            return response()->json(
                ['errors' => ['resource_not_found' => [$msg]]],
                404
            );
        }

        if ($exception instanceof AuthenticationException) {
            $msg = $exception->getMessage() ?: 'Unauthenticated.';

            return response()->json(
                ['errors' => ['unauthenticated' => [$msg]]],
                403
            );
        }

        if ($exception instanceof AuthorizationException) {
            $msg = $exception->getMessage() ?: 'Forbidden.';

            return response()->json(['errors' => ['forbidden' => [$msg]]], 403);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(
                ['errors' => ['method_not_allowed' => ['Method not allowed.']]],
                405
            );
        }

        if ($exception instanceof ThrottleRequestsException) {
            $msg = $exception->getMessage() ?: 'Too Many Attempts.';

            return response()->json(
                ['errors' => ['too_many_attempts' => [$msg]]],
                429
            );
        }

        if ($exception instanceof HttpException) {
            if ($exception->getStatusCode() === 401) {
                $msg = $exception->getMessage() ?: 'Unauthorized.';

                return response()->json(
                    ['errors' => ['unauthorized' => [$msg]]],
                    401
                );
            }

            if ($exception->getStatusCode() === 403) {
                $msg = $exception->getMessage() ?: 'Forbidden.';

                return response()->json(
                    ['errors' => ['forbidden' => [$msg]]],
                    403
                );
            }

            if ($exception->getStatusCode() === 404) {
                $msg = $exception->getMessage() ?: 'Resource not found.';

                return response()->json(
                    ['errors' => ['resource_not_found' => [$msg]]],
                    404
                );
            }
        }

        return parent::render($request, $exception);
    }
}
