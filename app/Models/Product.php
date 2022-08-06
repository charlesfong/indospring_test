<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // use HasFactory;
    protected $primaryKey = 'KODE_BARANG';
    public $timestamps = false;
    // protected $casts = ['id' => 'string','customer_price'=>'int','supplier_price'=>'int','weight'=>'int'];
    protected $keyType = 'string';
    protected $table = 'MSBARANG';
    protected $fillable = [
        'KODE_BARANG','NAMA_BARANG', 'SATUAN', 'KATEGORI'
    ];
    
    // public function supplier() {
    //     return $this->belongsTo('App\supplier','id_supplier');
    // }
}
