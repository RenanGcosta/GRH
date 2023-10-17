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
        Schema::create('exame', function (Blueprint $table) {
            $table->id();
            $table->string('exame');
            $table->integer('duracao');
            $table->string('tipo_periodo', 7);
            $table->enum('ativo', ['Sim', 'Não']);
            $table->timestamps();
        });

        DB::table('exame')->insert([
            [
                'exame' => 'HEMOGRAMA',
                'duracao' => 3,
                'tipo_periodo' => 'mês(es)',
                'ativo' => 'Sim',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'exame' => 'AUDIOMETRIA',
                'duracao' => 1,
                'tipo_periodo' => 'ano(s)',
                'ativo' => 'Sim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'exame' => 'ASO',
                'duracao' => 1,
                'tipo_periodo' => 'ano(s)',
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
        Schema::dropIfExists('exame');
    }
};
