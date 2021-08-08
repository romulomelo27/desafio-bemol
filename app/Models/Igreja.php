<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Igreja extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'razao_social',
        'nome_fantasia',
        'apelido',
        'cnpj',
        'cep',
        'rua',
        'numero',
        'complemento',
        'id_estado',
        'id_cidade',
        'telefone',
        'celular',
        'email',
        'logo',
        'ativo',
        'tipo'
    ];
}
