<?php

namespace App\Models;

use App\Traits\CreatedFromTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory ,CreatedFromTrait;
    protected $fillable = ['name', 'description', 'price', 'category_id'];
    protected $appends = ['created_from'];

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }




}
