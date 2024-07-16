<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alat_Lab extends Model
{
    use HasFactory;
    protected $table = 'alat__labs';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        "rfid_uid", "name", "isNeedPermission"
    ];
    public  function  peminjaman_Dosen(): HasMany
    {
        return  $this->hasMany(Peminjaman_Dosen::class, 'alat_lab_id', "id");
    }

    public  function  peminjaman_Mahasiswa(): HasMany
    {
        return  $this->hasMany(Peminjaman_Mahasiswa::class, "alat_lab_id", "id");
    }

    public  function alat_Terpinjam(): HasOne
    {
        return  $this->hasOne(Alat_Terpinjam::class, "alat_lab_id", "id");
    }
    public  function alert_Pencurian() : HasMany
    {
        return  $this->hasMany(Alert_Pencurian::class, "alat_lab_id", "id");
    }
}
