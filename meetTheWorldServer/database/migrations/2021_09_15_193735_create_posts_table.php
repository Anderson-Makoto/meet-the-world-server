<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("local_id");
            $table->date("date");
            $table->string("title");
            $table->string("description");
            $table->integer("user_id");
            $table->integer("tipo_id");
            $table->decimal("rating", 4, 3);
            $table->decimal("price", 10, 2);
            $table->foreign("local_id")->references("id")->on("locals")->onDelete("cascade");
            $table->foreign("tipo_id")->references("id")->on("tipos")->onDelete("cascade");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
