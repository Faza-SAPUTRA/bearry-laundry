<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Petugas extends Model
{
    use SoftDeletes;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable =
    [
        'nama_petugas',
        'no_telp',
        'jk',
        'status',
        'user_id'
    ];
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    protected $casts = [
        'deleted_at' => 'datetime',
    ];
}
