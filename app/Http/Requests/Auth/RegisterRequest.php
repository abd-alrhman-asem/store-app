<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\'-]+$/'
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\'-]+$/'
            ],
            'date_of_birth' => 'required|date',
            'country' => [
                'required',
                'string',
                'max:56',// Ensuring it covers the longest country name in
                'regex:/^[a-zA-Z\s-]+$/',
                ],
            'city' => [
                'required',
                'string',
                'max:168', // Ensuring it covers the longest city name
                'regex:/^[a-zA-Z\s]+$/', // Adjust the pattern to your needs
            ],
            'password' => [
                'required',
                'string',
                'between:8,25',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/',
            ],
            'email' => [
                'required',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'unique:users,email',
                'max:255',
                'email'
            ],
            'postal_code' => [
                'required',
                'string',
                'regex:/^(?:
                    \d{5}(?:-\d{4})?|                      # USA: 12345 or 12345-6789
                    [A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d|   # Canada: A1A 1A1 or A1A1A1
                    \d{4,5}|                               # Australia, Germany: 1234 or 12345
                    \d{2}[ ]?\d{3}|                        # France: 12 345 or 12345
                    \d{3,4}|                               # Denmark, Australia: 123 or 1234
                    \d{3}-\d{2}|                           # Brazil: 12345-678
                    \d{4}\s?[a-zA-Z]{2}|                   # Netherlands: 1234 AB
                    \d{5}-\d{3}|                           # Japan: 123-4567
                    \d{4}-\d{3}|\d{6}|                     # Russia: 123456 or 123-456
                    \d{5}|\d{3}-\d{4}|                     # Poland: 12345 or 12-345
                    [A-Za-z]{1,2}\d[A-Za-z\d]? \d[A-Za-z]{2}| # UK: W1A 1AA or SW1A 1AA
                    GIR 0AA                                # UK Special: GIR 0AA
                )$/x'  // x flag for extended mode
            ],
        ];
    }

    public function messages()
    {
        return [
            'first_name.regex' => 'The first name should only contain letters, spaces, hyphens, and apostrophes.',
            'last_name.regex' => 'The last name should only contain letters, spaces, hyphens, and apostrophes.',
            'email.regex' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'postal_code.between' => 'The postal code must be between 4 and 10 characters long.',
            'postal_code.regex' => 'Please enter a valid postal code.',
            'country.regex' => 'The country name should only contain letters, spaces, and hyphens.',
            'city.regex' => 'The city name should only contain letters and spaces.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $errorMessage = $validator->errors()->all();
        throw new HttpResponseException(
            response: unprocessableResponse(
                $errorMessage
            )
        );
    }

}
