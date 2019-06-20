<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;

/**
 * Class Handler
 */
class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Exception $exception Exception
     *
     * @return mixed|void
     * @throws Exception Exception
     */
    public function report(Exception $exception) // phpcs:ignore
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request   $request   Request
     * @param Exception $exception Exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) // phpcs:ignore
    {
        return parent::render($request, $exception);
    }

    /**
     * Unauthenticated error
     *
     * @param Request                 $request   Request
     * @param AuthenticationException $exception Exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception) // phpcs:ignore
    {
        return $request->expectsJson() ? response()->json([
            'message' => $exception->getMessage(),
            'route'   => route('login'),
        ], 401) : redirect()->guest(route('login'));
    }
}
