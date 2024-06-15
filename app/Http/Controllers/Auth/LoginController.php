<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(public AuthService $authService  )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->logInUser($request, $TokenExpireTime);
        return loggedInSuccessfully(
            $token,
            'the user logged in successfully',
            $TokenExpireTime
        );
    }
}
