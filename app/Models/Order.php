<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_ip',
        'product_id',
        'quantity',
        'status'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function userByIp(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ip_address', 'ip_address');
    }

    /**
     * @param $query
     * @param string|null $status
     * @return mixed
     */
    public function scopeStatus($query, ?string $status): mixed
    {
        if ($status !== null)
            return $query->where('status', $status);
        return $query;
    }


}
