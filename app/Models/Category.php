<?php

namespace App\Models;

use App\Traits\CreatedFromTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, CreatedFromTrait;
    protected $fillable = ['name', 'parent_id'];
    protected $appends = ['created_from'];
    /**
     * @return BelongsTo
     */
    public function parent():BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(
            Category::class,
            'parent_id'
        )->with(
            'children' ,
            'products'
        );
    }
    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);

    }
}
