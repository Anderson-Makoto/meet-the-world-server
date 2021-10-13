<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        "name",
        "email",
        "password",
        "tipo_id",
        "local_id",
        "budget"
    ];

    protected $hidden = [
        "password"
    ];

    public $timestamps = false;

    public function tipos () {
        $this->belongsTo(Tipo::class);
    }

    public function locals () {
        $this->belongsTo(Local::class);
    }
}
