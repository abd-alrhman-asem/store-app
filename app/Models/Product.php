<?php

namespace App\Models;

use App\Traits\CreatedFromTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory ,CreatedFromTrait;
    protected $fillable = ['name', 'description', 'price', 'category_id'];
    protected $appends = ['created_from'];

//    public function category()
//    {
//        return $this->belongsTo(Category::class);
//    }




}
