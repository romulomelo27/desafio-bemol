<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceitaTipo extends Model
{
    use HasFactory;

    protected $table = 'receitas_tipos';

    protected $fillable = [
        'id',
        'descricao',
        'ativo'
    ];


}
