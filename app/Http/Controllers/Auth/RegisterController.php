<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class RegisterController extends Controller
{
    public function __construct(public AuthService $authService)
    {
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    function __invoke(RegisterRequest $request): JsonResponse
    {
         $token = $this->authService->register($request);

        return loggedInSuccessfully(
            token:  $token ,
            message:  'Account created successfully.',
            statusCode : ResponseAlias::HTTP_CREATED
        );
    }
}
