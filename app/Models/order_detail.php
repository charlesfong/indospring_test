<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_detail extends Model
{
    use HasFactory;
    protected $primaryKey = 'NO_TRANSAKSI';
    public $timestamps = false;
    protected $casts = ['NO_TRANSAKSI' => 'string'];
    protected $table = 'TRMUTASIDT';
    protected $fillable = [
        'NO_TRANSAKSI', 'KODE_BARANG', 'QTY'
    ];

    // public function orders_details()
    // {
    //     return $this->belongsTo('App\order','id_order');
    // }
}
