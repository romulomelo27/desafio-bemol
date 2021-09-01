<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DespesaCategoria extends Model
{
    use HasFactory;

    protected $table = 'despesas_categorias';

    protected $fillable = [
        'id',
        'descricao',
        'ativo'
    ];


}
