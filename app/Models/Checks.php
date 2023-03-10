<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Checks extends Model
{
    protected $table = 'tbl_checks';

    use HasFactory;


    protected $fillable = [
        'nombre',
        'descripcion',
        'latitud',
        'longitud',
        'categoria_id',
    ];
}
