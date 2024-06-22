<?php

namespace App\Services;

use App\Exceptions\NoTokenException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Exception\InvalidArgumentException;
use Throwable;


class AuthService
{
    /**
     * @param RegisterRequest $request
     * @return string
     * @throws NoTokenException
     * @throws Throwable
     */
    public function register(RegisterRequest $request): string
    {
        $data = $request->validated(); // Get all validated data
        $data['ip_address'] = $request->ip();
        $user = $this->createUser($data);
        if (!$token = $user->createToken('auth_token')->plainTextToken)
            throw  new NoTokenException(
                "There was an error in the operation, please try again"
            );

        return $token;
    }

    /**
     * @param $data
     * @return mixed
     * @throws QueryException|Throwable
     */
    public function createUser($data): User
    {
        return User::create($data);
    }

    /**
     * @param loginRequest $request
     * @param $TokenExpireTime
     * @return string
     * @throws Exception
     */
    public function logInUser(loginRequest $request, &$TokenExpireTime): string
    {
        $validatedData = $request->validated(); // Access validated data from the request
        if (!$user = User::where('email', $validatedData['email'])->first())
            throw new ModelNotFoundException('there is no user for this email ');
        if (!Auth::attempt($request->only('email', 'password')))
            throw new InvalidArgumentException('Invalid credentials');
        if (!$token = $user->createToken('login-token')->plainTextToken)
            throw new NoTokenException(
                'there is some thing error please try again
                ');
        $TokenExpireTime = Carbon::now()->addMinutes(
            config('sanctum.expiration') / 60
        );
        $user->remember_token = $token;
        $user->save();
        return $token;
    }


}
