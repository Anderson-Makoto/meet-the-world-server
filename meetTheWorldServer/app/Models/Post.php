<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "local_id",
        "tipo_id",
        "user_id",
        "date",
        "price",
        "title",
        "description",
        "rating"
    ];

    protected $dateFormat = "dd-mm-yyyy";

    public $timestamps = false;

    public function tipos () {
        $this->belongsTo(Tipo::class);
    }

    public function locals () {
        $this->belongsTo(Local::class);
    }
}
