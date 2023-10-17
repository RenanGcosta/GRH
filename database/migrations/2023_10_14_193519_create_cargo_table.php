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
        Schema::create('cargo', function (Blueprint $table) {
            $table->id();
            $table->string('cargo', 50)->nullable();
            $table->enum('ativo', ['Sim', 'Não'])->nullable();
            $table->timestamps();
        });
        DB::table('cargo')->insert([
            ['cargo' => 'TÉCNICO EM EDIFICAÇÕES', 'ativo' => 'Sim', 'created_at' => now(), 'updated_at' => now()],
            ['cargo' => 'OPERADOR DE MÁQUINAS', 'ativo' => 'Sim', 'created_at' => now(), 'updated_at' => now()],
            ['cargo' => 'LEITURISTA', 'ativo' => 'Sim', 'created_at' => now(), 'updated_at' => now()],
            ['cargo' => 'ENGENHARIA', 'ativo' => 'Sim', 'created_at' => now(), 'updated_at' => now()],
            ['cargo' => 'TORNEIRO', 'ativo' => 'Sim', 'created_at' => now(), 'updated_at' => now()],
            ['cargo' => 'TÉCNICO EM SEGURANÇA NO TRABALHO', 'ativo' => 'Sim', 'created_at' => now(), 'updated_at' => now()],
            ['cargo' => 'FERRAMENTEIRO', 'ativo' => 'Sim', 'created_at' => now(), 'updated_at' => now()],
        ]); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cargo');
    }
};
