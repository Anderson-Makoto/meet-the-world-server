<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tipo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("tipos")->insert([
            [
                "id" => 0,
                "name" => "mochilão"
            ],
            [
                "id" => 1,
                "name" => "natureza"
            ],
            [
                "id" => 2,
                "name" => "romântica"
            ]
            ]);
    }
}
