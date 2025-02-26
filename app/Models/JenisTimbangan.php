<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTimbangan extends Model
{
    protected $table = 'jenis_timbangan'; // Nama tabel
    protected $primaryKey = 'id_jenis_timbangan'; // Primary key
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['nama_jenis_timbangan'];
    use HasFactory;

    public function jenisCucian()
    {
        return $this->hasMany(JenisCucian::class, 'id_jenis_timbangan');
    }

    
}
