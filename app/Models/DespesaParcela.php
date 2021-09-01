<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DespesaParcela extends Model
{
    use HasFactory;

    protected $table = 'despesas_parcelas';

    protected $fillable = [
        'id_despesa',
        'numero',
        'valor_parcela',
        'juros',
        'desconto',
        'total_parcela',
        'data_vencimento',
        'data_pagamento',
        'id_conta',
        'id_user_baixa',
    ];
}
