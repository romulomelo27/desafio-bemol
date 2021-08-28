<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    protected $fillable = [

        'id', 
        'razao_social',
        'nome_fantasia',
        'tipo',
        'documento',
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
    ];
}
