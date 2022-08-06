<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_log extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'customers_log';
    protected $fillable = [
        'id_customer','name', 'address', 'phone1','phone2', 'phone3', 'email', 'UPDATED_AT','UPDATED_BY'
    ];
}
