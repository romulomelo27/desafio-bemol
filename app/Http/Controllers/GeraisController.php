<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeraisController extends Controller
{
    public function setFormatoAmericano($valor)
    {

        $valor = str_replace(".", "", $valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);

        $valor = (float) $valor;

        return $valor;
    }

}
