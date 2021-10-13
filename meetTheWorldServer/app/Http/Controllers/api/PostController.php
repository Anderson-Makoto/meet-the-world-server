<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Exception;

class PostController extends Controller
{
    public function store (Request $request) {
        $request->validate([
            "local_id" => "required|integer",
            "tipo_id" => "required|integer",
            "user_id" => "required|integer",
            "date" => "required|date",
            "price" => "required|numeric",
            "title" => "required|string",
            "description" => "required|string"
        ]);

        try {
            $post = Post::create([
                "local_id" => $request->input("local_id"),
                "tipo_id" => $request->input("tipo_id"),
                "user_id" => $request->input("user_id"),
                "date" => $request->input("date"),
                "price" => $request->input("price"),
                "title" => $request->input("title"),
                "description" => $request->input("description"),
                "rating" => 0
            ]);

            return response()->json([
                "data" => $post
            ], 201);
    
        } catch (Exception $e) {
            return response()->json([
                "data" => $e->getMessage()
            ], 500);
        }

    }

    public function index () {
        try {
            $posts = Post::where("user_id", auth()->user()->id)->get();

            return response()->json([
                "data" => $posts
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "data" => $e
            ], 500);
        }
    }

    public function show ($id) {
        try {
            $post = Post::where("user_id", auth()->user()->id)->where("id", $id)->first();

            return response()->json([
                "data" => $post
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "data" => $e->getMessage()
            ], 500);
        }
    }

    public function getPostsResume () {
        try {

            $posts = Post::select("title", "id", "rating")
                ->where("user_id", "<>", auth()->user()->id)
                ->where("price", "<=", auth()->user()->budget + 200)
                ->where("tipo_id", auth()->user()->tipo_id)
                ->where("local_id", auth()->user()->local_id)
                ->orderBy("price", "asc")
                ->orderBy("rating", "desc")
                ->get();

            return response()->json([
                "data" => $posts
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                "data" => $e->getMessage()
            ], 500);

        }
    }

    public function destroy ($id) {

        try {
            $post = Post::where("id", $id)->delete();

            return response()->json([
                "data" => $post
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "data" => $e->getMessage()
            ], 500);
        }

    }
}
