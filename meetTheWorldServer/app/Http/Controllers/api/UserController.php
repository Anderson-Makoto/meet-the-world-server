<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            "name" => "required|string",
            "email" => "required|string",
            "password" => "required|string",
            "tipo_id" => "required|integer",
            "local_id" => "required|integer",
            "budget" => "required|numeric"
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                "name" => $request->input("name"),
                "email" => $request->input("email"),
                "password" => Hash::make($request->input("password")),
                "tipo_id" => $request->input("tipo_id"),
                "local_id" => $request->input("local_id"),
                "budget" => $request->input("budget")
            ]);

            $token = $user->createToken("API token")->plainTextToken;

            DB::commit();

            return response()->json([
                "data" => $user,
                "token" => $token
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            if ($e->errorInfo[0] == "23000") {
                return response()->json([
                    "data" => "Email já cadastrado"
                ], 402);
            } else {
                return response()->json([
                    "data" => $e
                ], 500);
            }
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|string",
            "password" => "required|string"
        ]);

        $user = User::where("email", $request->input("email"))->first();

        if ($user) {
            if (Hash::check($request->input("password"), $user->password)) {

                $token = $user->createToken("API token")->plainTextToken;

                return response()->json([
                    "data" => $user,
                    "token" => $token
                ], 200);
            } else {
                return response()->json([
                    "data" => "Senha inválida"
                ], 402);
            }
        } else {
            return response()->json([
                "data" => "Usuário não cadastrado"
            ], 404);
        }
    }

    public function logout($id)
    {
        try {
            $user = User::where("id", $id)->first();

            $user->tokens()->delete();

            return response()->json([
                "data" => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "data" => $e->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string",
            "tipo_id" => "required|integer",
            "local_id" => "required|integer",
            "budget" => "required|numeric"
        ]);

        try {
            $user = User::where("id", $id)->update([
                "name" => $request->input("name"),
                "tipo_id" => $request->input("tipo_id"),
                "local_id" => $request->input("local_id"),
                "budget" => $request->input("budget")
            ]);

            return response()->json([
                "data" => $user
            ], 200);
        } catch (Exception $e) {
            dd($e->getMessage());
            return response()->json([
                "data" => $e->getMessage()
            ], 500);
        }
    }
}
