<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\QueryException;
use PDOException;

use Throwable;
class Handler extends ExceptionHandler
{
    protected array $exceptionHandlers = [
        ModelNotFoundException::class => 'handleModelNotFoundException',
        NotFoundHttpException::class => 'handleNotFoundHttpException',
        UnprocessableEntityHttpException::class => 'handleUnprocessableEntityException',
        AuthenticationException::class => 'handleAuthenticationException',
        AuthorizationException::class => 'handleAuthorizationException',
        BadRequestHttpException::class => 'handleBadRequestException',
        ConflictHttpException::class => 'handleConflictHttpException',
        NoTokenException::class => 'handleAuthenticationException',
//        QueryException::class => 'handleQueryException',
    ];

    public function register(): void
    {
dump( 'handler register  ');
        $this->renderable(function (Throwable $e, $request) {
            return $this->handleException($e);
        });
    }

    protected function handleException(Throwable $e): JsonResponse
    {
        dump( 'handler handle Exceptions   ');

        foreach ($this->exceptionHandlers as $exception => $handler) {
//            dump($e);
            if ($e instanceof $exception) {
//            dump('e');
                return $this->{$handler}($e);
            }
        }

        return $this->handleDefaultException($e);
    }
    protected function handleNoTokenException(NoTokenException $e): JsonResponse
    {
        //TODO:REFACTOR THIS FUNCTION FOR THE RESPONSE
        return notFoundResponse("Not Found: " . $e->getMessage());
    }
//    protected function handleQueryException(QueryException $e): JsonResponse
//    {
//        //TODO:REFACTOR THIS FUNCTION FOR THE RESPONSE
//        return QueryError("database error : " . $e->getMessage());
//    }
    protected function handleNotFoundHttpException(NotFoundHttpException $e): JsonResponse
    {
        return notFoundResponse("Not Found: " . $e->getMessage());
    }
    protected function handleConflictHttpException(ConflictHttpException $e): JsonResponse
    {
        return conflictResponse("conflict : " . $e->getMessage());
    }
    protected function handleModelNotFoundException(ModelNotFoundException $e): JsonResponse
    {
        return notFoundResponse("handler: " . $e->getMessage());
    }

    protected function handleUnprocessableEntityException(UnprocessableEntityHttpException $e): JsonResponse
    {
        return unprocessableResponse("handler: " . $e->getMessage());
    }

    protected function handleAuthenticationException(AuthenticationException $e): JsonResponse
    {
        return unauthorizedResponse("handler: " . $e->getMessage());
    }

    protected function handleAuthorizationException(AuthorizationException $e): JsonResponse
    {
        return forbiddenResponse("handler: " . $e->getMessage());
    }

    protected function handleBadRequestException(BadRequestHttpException $e): JsonResponse
    {
        return badRequestResponse("handler: " . $e->getMessage());
    }

    protected function handleDefaultException(Throwable $e): JsonResponse
    {
        if ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
        } else {
            $statusCode = 500;
        }

        return generalFailureResponse($e->getMessage(), $statusCode);
    }
}
