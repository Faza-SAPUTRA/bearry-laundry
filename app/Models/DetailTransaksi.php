<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{

    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable =
    [
        'berat',
        'harga_per_timbangan',
        'sub_total',
        'nama_jenis_timbangan',
        'id_transaksi',
        'id_jenis_cucian',
        'id_jenis_timbangan',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($detailTransaksi) {
            // Ambil ID terakhir dari database dan buat ID baru
            $lastId = self::max('id_detail_transaksi');
            $newIdNumber = $lastId ? (int) substr($lastId, 5) + 1 : 1;
            $detailTransaksi->id_detail_transaksi = 'DTRLR' . str_pad($newIdNumber, 5, '0', STR_PAD_LEFT);
        });
    }
    
    public function jenisCucian()
    {
        return $this->belongsTo(JenisCucian::class, 'id_jenis_cucian');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
    public function jenisTimbangan()
    {
        return $this->hasOneThrough(
            JenisTimbangan::class,
            JenisCucian::class,
            'id', // Foreign key pada JenisCucian
            'id_jenis_timbangan', // Foreign key pada JenisTimbangan
            'id_jenis_cucian', // Local key pada DetailTransaksi
            'id_jenis_timbangan' // Local key pada JenisCucian
        );
    }
    use HasFactory;
}
