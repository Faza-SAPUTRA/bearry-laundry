<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisCucian extends Model
{
    protected $table = 'jenis_cucian'; // Nama tabel
    protected $primaryKey = 'id_jenis_cucian'; // Primary key
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_jenis_cucian', // Nama jenis cucian (misal: Kiloan, Satuan)
        'harga_per_timbangan',
        'id_jenis_timbangan',
        'deleted_at'
    ];
    use HasFactory, SoftDeletes;

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_jenis_cucian');
    }

    public function jenisTimbangan()
    {
        return $this->belongsTo(JenisTimbangan::class, 'id_jenis_timbangan');
    }
}
