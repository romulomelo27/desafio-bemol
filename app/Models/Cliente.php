<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_user',
        'nome',
        'id_igreja',
        'cpf',
        'rg',
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
        'tipo',
        'foto'        
    ];
}
