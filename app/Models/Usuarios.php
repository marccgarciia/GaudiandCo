<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Usuarios extends Model
{
    protected $table = 'tbl_usuarios';

    use HasFactory;


    protected $fillable = [
        'nombre',
        'email',
        'pswd',
    ];
}
