<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Peminjaman_Dosen extends Model
{
    use HasFactory;
    protected $table = 'peminjaman__dosens';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable =[
        "alat_lab_id",
        "dosen_id",
        "keperluan",
        "tempat_pemakaian",
        "tanggal_peminjaman",
        "tanggal_pengembalian",
        "accepted",
        "sudah_dikembalikan"
    ];
    public function  dosen() : BelongsTo
    {
        return $this->belongsTo(Dosen::class, "dosen_id", "id");
    }
    public  function alat_Lab(): BelongsTo
    {
        return  $this->belongsTo(Alat_Lab::class, "alat_lab_id", "id");
    }

}
