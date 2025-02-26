<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Transaksi extends Model
{

    protected $table = 'Transaksi';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable =
    [
        'status',
        'diskon',
        'total_harga', // Ganti dari total_harga
        'total_harga_setelah_diskon',
        'estimasi_tanggal_pengambilan',
        'status_pembayaran',
        'created_at',
        'updated_at',
        'id_customer',
        'bukti_pembayaran',
        'user_id', // Tambahkan ini
    ];
    use HasFactory, Notifiable;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            // Ambil ID terakhir dari database dan buat ID baru
            $lastId = self::max('id_transaksi');
            $newIdNumber = $lastId ? (int) substr($lastId, 4) + 1 : 1;
            $transaksi->id_transaksi = 'TRLR' . str_pad($newIdNumber, 5, '0', STR_PAD_LEFT);
        });
    }
    public function detailTransaksi(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer')->withTrashed();
    }


    // Tambahkan relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function scopeLastTwoWeeks(Builder $query): Builder
    {
        return $query->where('created_at', '>=', now()->subWeeks(2));
    }
}
