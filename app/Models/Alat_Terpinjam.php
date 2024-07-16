<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alat_Terpinjam extends Model
{
    use HasFactory;
    protected $table = 'alat__terpinjams';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable =[
        "alat_lab_id", "tanggal_terpinjam", "tanggal_kembali", "dikembalikan", 'peminjam_type',
        'peminjam_id',
        'form_peminjaman_type',
        'form_peminjaman_id',
    ];
    public function alat_Lab(): BelongsTo
    {
        return  $this->belongsTo(Alat_Lab::class, "alat_lab_id", "id");
    }

}
