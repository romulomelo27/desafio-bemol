<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_igreja',
        'id_pessoa',
        'id_user',
        'id_tipo',
        'valor1',
        'valor2',
        'total',
        'data',
        'id_conta',
        'observacao'
    ];
}
