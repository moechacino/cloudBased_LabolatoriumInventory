<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alert_Pencurian extends Model
{
    protected $table = 'alert__pencurians';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;

    public  function alat_Lab(): BelongsTo
    {
        return  $this->belongsTo(Alat_Lab::class, "alat_lab_id", "id");
    }

    public  function foto(): HasMany
    {
        return  $this->hasMany(Foto::class, "alert_id", "id");
    }
}
