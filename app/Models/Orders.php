<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'discount',     
        'final_amount', 
        'status',
        'address_text',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Users::class);
    }

    public function items()
    {
        return $this->hasMany(Order_Items::class);
    }

    public function vouchers()
    {
        return $this->belongsToMany(Vouchers::class, 'voucher_usages')
                    ->withPivot('user_id', 'used_at');
    }
}
