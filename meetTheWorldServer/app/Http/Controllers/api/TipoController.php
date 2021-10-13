<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Exception;

class TipoController extends Controller
{
    public function getAll () {

        try {
            $tipos = Tipo::get();

            return response()->json([
                "data" => $tipos
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "data" => $e->getMessage()
            ], 500);
        }
    }
}
