<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoaAtribuicoes extends Model
{
    use HasFactory;

    protected $table = 'pessoas_atribuicoes';

    protected $fillable = [
        'id_pessoa',
        'id_atribuicao'
    ];

    public $timestamp = false;


}
