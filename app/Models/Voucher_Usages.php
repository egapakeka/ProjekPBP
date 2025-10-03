<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher_Usages extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_id', 'user_id', 'order_id', 'used_at',
    ];

    public $timestamps = false;

    public function voucher()
    {
        return $this->belongsTo(Vouchers::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
