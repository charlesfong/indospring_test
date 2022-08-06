<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $primaryKey = 'NO_TRANSAKSI';
    public $timestamps = false;
    protected $casts = ['NO_TRANSAKSI' => 'string'];
    protected $table = 'TRMUTASIHD';
    protected $fillable = [
        'NO_TRANSAKSI','TANGGAL','JENIS_TRANSAKSI','KATEGORI'
    ];

    // public function orders_details()
    // {
    //     return $this->hasMany('App\order_detail','id','id_order');
    // }
}
