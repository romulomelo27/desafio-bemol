<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceitaCategoria extends Model
{
    use HasFactory;

    protected $table = 'receitas_categorias';

    protected $fillable = [
        'id',
        'descricao',
        'ativo'
    ];


}
