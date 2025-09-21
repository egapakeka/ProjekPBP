<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'discount_type', 'discount_value',
        'min_purchase', 'max_discount', 'start_date', 'end_date',
        'usage_limit', 'per_user_limit'
    ];

    public $timestamps = false;

    public function usages()
    {
        return $this->hasMany(Voucher_Usages::class);
    }

    public function users()
    {
        return $this->belongsToMany(Users::class, 'voucher_usages')
                    ->withPivot('order_id', 'used_at');
    }
}