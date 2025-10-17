<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'discount_type', 'discount_value', 'min_purchase',
        'max_discount', 'start_date', 'end_date', 'usage_limit', 'per_user_limit',
    ];

    public $timestamps = false; 

    // Relasi ke tabel usage
    public function usages()
    {
        return $this->hasMany(Voucher_Usages::class);
    }

    // Relasi ke user melalui tabel usage
    public function users()
    {
        return $this->belongsToMany(User::class, 'voucher_usages')
                    ->withPivot('order_id')
                    ->withTimestamps();
    }

    public function isValidFor($user, $amount)
    {
        $today = now()->toDateString();

        // cek tanggal berlaku
        if ($today < $this->start_date || $today > $this->end_date) {
            return false;
        }

        // cek minimal belanja
        if ($amount < $this->min_purchase) {
            return false;
        }

        // cek limit global
        if (!is_null($this->usage_limit) && $this->usages()->count() >= $this->usage_limit) {
            return false;
        }

        // cek limit per user
        if (!is_null($this->per_user_limit) &&
            $this->usages()->where('user_id', $user->id)->count() >= $this->per_user_limit) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->discount_type === 'percent') {
            $discount = $amount * ($this->discount_value / 100);
        } else {
            $discount = $this->discount_value;
        }

        if (! is_null($this->max_discount)) {
            $discount = min($discount, $this->max_discount);
        }

        return (float) max(min($discount, $amount), 0);
    }
}
