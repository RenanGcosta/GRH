<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionario', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->integer('matricula')->nullable();
            $table->string('sexo', 50)->nullable();
            $table->string('RG', 20)->nullable();
            $table->string('CPF', 20)->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('email', 80)->nullable();
            $table->date('data_admissao')->nullable();
            $table->string('foto')->nullable();

            $table->string('CEP', 20)->nullable();
            $table->string('logradouro', 250)->nullable();
            $table->string('numero', 8)->nullable();
            $table->string('estado', 20)->nullable();
            $table->string('bairro', 80)->nullable();
            $table->string('cidade', 90)->nullable();
            $table->string('observacao', 1000)->nullable();

            //(FK) table users
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')
            ->onUpdate('restrict')->onDelete('restrict');

            //(FK) table cargo
            $table->unsignedBigInteger('id_cargo');
            $table->foreign('id_cargo')->references('id')->on('cargo')
            ->onUpdate('restrict')->onDelete('restrict');

            //(FK) table departamento
            $table->unsignedBigInteger('id_departamento');
            $table->foreign('id_departamento')->references('id')->on('departamento')
            ->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionario');
    }
};
