<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'description', 'price', 'stock', 'category_id', 'is_active'];

    public $timestamps = false;

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart_Items::class);
    }

    public function orderItems()
    {
        return $this->hasMany(Order_Items::class);
    }
}
