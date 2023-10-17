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
        Schema::create('treinamento', function (Blueprint $table) {
            $table->id();
            $table->string('treinamento');
            $table->integer('duracao');
            $table->string('tipo_periodo'); // Remova o tamanho aqui
            $table->enum('ativo', ['Sim', 'Não']);
            $table->timestamps();
        });

        DB::table('treinamento')->insert([
            [
                'treinamento' => 'NR10',
                'duracao' => 2,
                'tipo_periodo' => 'ano(s)',
                'ativo' => 'Sim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'treinamento' => 'NR18',
                'duracao' => 1,
                'tipo_periodo' => 'ano(s)',
                'ativo' => 'Sim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'treinamento' => 'NR33',
                'tipo_periodo' => 'ano(s)',
                'duracao' => 1,
                'ativo' => 'Sim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'treinamento' => 'NR35',
                'tipo_periodo' => 'ano(s)',
                'duracao' => 2,
                'ativo' => 'Sim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treinamento');
    }
};