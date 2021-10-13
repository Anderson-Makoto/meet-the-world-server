<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->string("email")->unique();
            $table->string("password");
            $table->decimal("budget", 10, 2);
            $table->integer("tipo_id");
            $table->integer("local_id");
            $table->foreign("tipo_id")->references("id")->on("tipos")->onDelete("cascade");
            $table->foreign("local_id")->references("id")->on("locals")->onDelete("cascade");
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
