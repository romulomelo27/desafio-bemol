<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extrato extends Model
{
    use HasFactory;

    protected $fillable = [

        'id', 
        'id_lancamento',
        'origem_lancamento',
        'id_parcela',
        'id_igreja',
        'id_pessoa_forn',
        'id_conta',
        'id_categoria',
        'valor1',
        'valor2',
        'juros',
        'desconto',
        'total',
        'estornado'
    ];
}
