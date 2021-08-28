<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_igreja',
        'id_fornecedor',
        'id_user',
        'id_categoria',
        'numero_documento',
        'valor',
        'juros',
        'desconto',
        'total',
        'numero_parcelas',
        'data',
        'observacao'
    ];
}
