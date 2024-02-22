<?php

namespace App\Exceptions;

use App\Helpers\APIHelper;
use App\Helpers\APIResponseMessage;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Exception;

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
        $this->renderable(function (UnauthorizedException $e, $request) {
            return APIHelper::responseBuilder(
                Response::HTTP_UNAUTHORIZED,
                APIResponseMessage::UNAUTHORIZED,
                'error', $e->getMessage());
        });

        $this->renderable(function (Exception $e, $request) {
            return $this->handleException($request, $e);
        });
    }

    public function handleException($request, Exception $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return APIHelper::responseBuilder(
                Response::HTTP_UNAUTHORIZED,
                APIResponseMessage::UNAUTHORIZED,
                'error', $exception->getMessage());
        }

        if ($exception instanceof NotFoundHttpException) {
            return APIHelper::responseBuilder(
                Response::HTTP_NOT_FOUND,
                APIResponseMessage::ROUTE_NOT_FOUND,
                'error', $exception->getMessage());
        }

    }
}
