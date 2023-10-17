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
        Schema::create('departamento', function (Blueprint $table) {
            $table->id();
            $table->string('departamento', 60)->nullable();
            $table->enum('ativo', ['Sim', 'Não'])->nullable();
            $table->timestamps();
        });
        DB::table('departamento')->insert([
            [
                'departamento' => 'MANUTENÇÃO CIVIL CHESF',
                'ativo' => 'Sim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'departamento' => 'ADMINISTRAÇÃO',
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
        Schema::dropIfExists('departamento');
    }
};
