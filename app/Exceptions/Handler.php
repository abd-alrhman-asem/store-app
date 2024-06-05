<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use PDOException;
use Ramsey\Uuid\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
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


    public function render($request, Throwable $e): JsonResponse
    {
        switch (true) {
            case $e instanceof ModelNotFoundException:
                return notFoundResponse("handler:" . $e->getMessage());
            case $e instanceof UnprocessableEntityHttpException:
                return unprocessableResponse("handler:" . $e->getMessage());
            case $e instanceof AuthenticationException:
                return unauthorizedResponse("handler" . $e->getMessage());
            case $e instanceof AuthorizationException:
                return forbiddenResponse("handler:" . $e->getMessage());
            case $e instanceof BadRequestException :
                return badRequestResponse('handler:' . $e->getMessage());
            case $e instanceof QueryException :
            case $e instanceof ValidationException:
            case $e instanceof InvalidArgumentException:
            case $e instanceof HttpException:
                $statusCode = $e->getStatusCode();
                $message = 'handler:' . $e->getMessage();
                break;
            default:
                $statusCode = 500;
                $message = 'handler : Internal Server Error';
                break;
        }
        return generalFailureResponse($message, $statusCode);
    }

}
