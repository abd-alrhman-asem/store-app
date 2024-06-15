<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function creating(User $user): void
    {
        $postalCode = request('postal_code', '');
        $country = request('country', '');
        $city = request('city', '');
        // Concatenate the values into the address column
        $user->address = "{$postalCode}, {$country}, {$city}";

    }
}
