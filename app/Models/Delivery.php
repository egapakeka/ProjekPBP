<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'deliveries'; // tambahkan ini!

    protected $fillable = [
        'pesanan_id',
        'kurir',
        'no_resi',
        'status_pengiriman',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'pesanan_id');
    }
}
