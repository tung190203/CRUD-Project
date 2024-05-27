<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = 'INTERNAL_SERVER_ERROR';

            if ($exception instanceof ValidationException) {
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                $message = 'VALIDATION_ERROR';
            } elseif ($exception instanceof AuthenticationException) {
                $status = Response::HTTP_UNAUTHORIZED;
                $message = 'UNAUTHORIZED';
            } elseif ($exception instanceof AuthorizationException) {
                $status = Response::HTTP_FORBIDDEN;
                $message = 'FORBIDDEN';
            } elseif ($exception instanceof ModelNotFoundException) {
                $status = Response::HTTP_NOT_FOUND;
                $message = 'NOT_FOUND';
            } elseif ($exception instanceof NotFoundHttpException) {
                $status = Response::HTTP_NOT_FOUND;
                $message = 'NOT_FOUND';
            } elseif ($exception instanceof MethodNotAllowedHttpException) {
                $status = Response::HTTP_METHOD_NOT_ALLOWED;
                $message = 'METHOD_NOT_ALLOWED';
            } elseif ($exception instanceof BadRequestHttpException) {
                $status = Response::HTTP_BAD_REQUEST;
                $message = 'BAD_REQUEST';
            } elseif ($exception instanceof UnauthorizedHttpException) {
                $status = Response::HTTP_UNAUTHORIZED;
                $message = 'UNAUTHORIZED';
            } elseif ($exception instanceof AccessDeniedHttpException) {
                $status = Response::HTTP_FORBIDDEN;
                $message = 'FORBIDDEN';
            }

            return responseError($status, $message, $exception->getMessage());
        }

        return parent::render($request, $exception);
    }
}
