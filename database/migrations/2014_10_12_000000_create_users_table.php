<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome',);
            $table->string('username')->unique();
            $table->timestamp('username_verified_at')->nullable();
            $table->string('password');
            $table->enum('tipo', ['simples', 'admin']);
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert([
            'nome' => 'master',
            'username' => 'master',
            'password' => '$2y$10$bNp4/zK9xmvZ8wPbjwXZheaUn1t8CZJHfTMXzVgs/yOfzR7bv2pIm',
            'tipo' => 'admin',
            'created_at' => '2023-10-16 00:40:49',
            'updated_at' => '2023-10-16 00:40:49',
        ]);
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
};
