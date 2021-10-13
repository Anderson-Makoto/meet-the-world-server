<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Local;
use Illuminate\Http\Request;
use Exception;

class LocalController extends Controller
{
    public function getAll () {
        try {
            $locals = Local::get();

            return response()->json([
                "data" => $locals
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                "data" => $e->getMessage()
            ], 500);
        }
    }
}
