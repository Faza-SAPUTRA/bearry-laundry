<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customer';
    protected $primaryKey = 'id_customer';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable =
    [
        'nama_customer',
        'no_telp',
        'alamat',
        'tipe_customer',
        'deleted_at',
    ];
}
