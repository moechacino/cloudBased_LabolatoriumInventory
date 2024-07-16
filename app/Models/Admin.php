<?php

namespace App\Models;

use App\Traits\HasUuid;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;



class Admin extends Model
{
    use HasUuid, Notifiable;

    protected $guarded = "admins";
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
    public $incrementing = false;

    protected $fillable =[
        "username", "password"
    ];


}
