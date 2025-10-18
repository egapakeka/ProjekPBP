<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Voucher_Usages;

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

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Order_Items::class, 'order_id');
    }

    public function voucherUsages()
    {
        return $this->hasMany(Voucher_Usages::class, 'order_id');
    }

    public function vouchers()
    {
        return $this->belongsToMany(Vouchers::class, 'voucher_usages', 'order_id', 'voucher_id')
                    ->withPivot('user_id')
                    ->withTimestamps();
    }
}
