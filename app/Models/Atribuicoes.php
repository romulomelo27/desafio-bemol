<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atribuicoes extends Model
{
    use HasFactory;

    protected $table = 'atribuicoes';

    protected $fillable = [
        'id',
        'descricao',
        'ativo'
    ];


}
