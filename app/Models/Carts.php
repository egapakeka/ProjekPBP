<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Cart_Items::class);
    }
}
