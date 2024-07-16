<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosens';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        "rfid_uid", "name", "nidn"
    ];
    public function peminjaman_Dosen() : HasMany
    {
        return $this->hasMany(Peminjaman_Dosen::class, "dosen_id", "id" );
    }
    public function peminjaman_Mahasiswa() : HasMany
    {
        return  $this->hasMany(Peminjaman_Mahasiswa::class, "dosen_id", "id");
    }
}
