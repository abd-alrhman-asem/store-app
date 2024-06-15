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
use Laravel\Sanctum\string;
use Ramsey\Uuid\Exception\InvalidArgumentException;
use Throwable;


class AuthService
{

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return string
     * @throws QueryException|Throwable
     */
    public function register(RegisterRequest $request): string
    {
        $data = $request->validated(); // Get all validated data
        $user = $this->createUser($data, $request->ip());
        if (!$token = $user->createToken('auth_token')->plainTextToken)
            throw  new NoTokenException(
                'there is some error in the recitation , please try again '
            );
        return $token;
    }

    /**
     * @param array $data
     * @return string
     */
    private function formatAddress(array $data): string
    {
        return (
            $data['postal_code'] .",".
            $data['country'] .",".
            $data['city']
        );
    }

    /**
     * @param $data
     * @return mixed
     * @throws QueryException|Throwable
     */
    public function createUser($data, $ip_address): User
    {
        $address = $this->formatAddress($data);
        return $user = User::create([
            'ip_address' => $ip_address,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'date_of_birth' => $data['date_of_birth'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $address,
        ]);
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
