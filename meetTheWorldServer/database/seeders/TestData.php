<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // criando usuarios
        User::create([
            "name" => "Anderson Makoto",
            "email" => "anderson@email.com",
            "password" => Hash::make("123123"),
            "local_id" => 50,
            "tipo_id" => 1,
            "budget" => 15000
        ]);
        User::create([
            "name" => "Samir Antoun",
            "email" => "samir@email.com",
            "password" => Hash::make("123456"),
            "local_id" => 25,
            "tipo_id" => 2,
            "budget" => 10000.75
        ]);
        User::create([
            "name" => "Marcos Airam",
            "email" => "marcos@email.com",
            "password" => Hash::make("321321"),
            "local_id" => 100,
            "tipo_id" => 0,
            "budget" => 5000.5
        ]);
        User::create([
            "name" => "Omar Condori",
            "email" => "omar@email.com",
            "password" => Hash::make("654321"),
            "local_id" => 54,
            "tipo_id" => 0,
            "budget" => 5000.5
        ]);
        
        // criando posts
        Post::create([
            "local_id" => 15,
            "tipo_id" => 1,
            "user_id" => 1,
            "date" => "01-08-2018",
            "price" => 5000.70,
            "title" => "Local da Austrália usuario 1",
            "description" => "descrição da viagem da austrália",
            "rating" => 3.565
        ]);
        Post::create([
            "local_id" => 27,
            "tipo_id" => 2,
            "user_id" => 1,
            "date" => "04-07-2019",
            "price" => 3500,
            "title" => "Local da Bolívia usuario 1",
            "description" => "descrição da viagem da bolívia",
            "rating" => 4.25
        ]);
        Post::create([
            "local_id" => 57,
            "tipo_id" => 1,
            "user_id" => 1,
            "date" => "01-08-2020",
            "price" => 10650,
            "title" => "Local do Egito usuario 1",
            "description" => "descrição da viagem do egito",
            "rating" => 4.723
        ]);
        Post::create([
            "local_id" => 15,
            "tipo_id" => 0,
            "user_id" => 2,
            "date" => "01-08-2018",
            "price" => 20000,
            "title" => "Local da Austrália usuario 2",
            "description" => "descrição da viagem da austrália",
            "rating" => 2.645
        ]);
        Post::create([
            "local_id" => 50,
            "tipo_id" => 1,
            "user_id" => 2,
            "date" => "01-08-2018",
            "price" => 8000,
            "title" => "Local da Cost do Marfim usuario 2",
            "description" => "descrição da viagem da costa do marfim",
            "rating" => 2.645
        ]);
        Post::create([
            "local_id" => 50,
            "tipo_id" => 1,
            "user_id" => 3,
            "date" => "01-08-2018",
            "price" => 10000,
            "title" => "Local da Cost do Marfim usuario 2",
            "description" => "descrição da viagem da costa do marfim",
            "rating" => 4.33
        ]);
    }
}
