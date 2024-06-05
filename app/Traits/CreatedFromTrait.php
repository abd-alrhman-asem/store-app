<?php

namespace App\Traits;

use Carbon\Carbon;

trait CreatedFromTrait
{
    public function getCreatedFromAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
}
