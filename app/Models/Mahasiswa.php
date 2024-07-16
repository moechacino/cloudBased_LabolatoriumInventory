<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswas';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        "rfid_uid", "name", "nrp"
    ];
    public function peminjaman_Mahasiswa() : HasMany
    {
        return  $this->hasMany(Peminjaman_Mahasiswa::class, "mahasiswa_id", "id");
    }

}
