<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher_Usages extends Model
{
    use HasFactory;

    protected $table = 'voucher_usages';

    protected $fillable = [
        'voucher_id', 'user_id', 'order_id',
    ];

    public $timestamps = true;

    public function voucher()
    {
        return $this->belongsTo(Vouchers::class, 'voucher_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }
}
