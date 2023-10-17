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
        Schema::create('func_x_exame', function (Blueprint $table) {
            $table->id();
            $table->date('data_validade')->nullable();
            $table->string('anotacao')->nullable();

            //(FK) table users
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')
            ->onUpdate('restrict')->onDelete('restrict');

            //(FK) table exame
            $table->unsignedBigInteger('id_exame');
            $table->foreign('id_exame')->references('id')->on('exame')
            ->onUpdate('restrict')->onDelete('restrict');

            //(FK) table funcionario
            $table->unsignedBigInteger('id_funcionario');
            $table->foreign('id_funcionario')->references('id')->on('funcionario')
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
        Schema::dropIfExists('func_x_exame');
    }
};
