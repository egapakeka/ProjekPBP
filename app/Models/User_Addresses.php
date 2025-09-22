<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Addresses extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'label', 'recipient_name', 'phone',
        'street', 'city', 'province', 'postal_code',
        'is_default'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}
