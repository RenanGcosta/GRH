<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Treinamento;
use App\Models\Funcionario;

class FuncionarioTreinamento extends Model
{
    use HasFactory;
    protected $table = 'func_x_treinamento';
    protected $fillable = [
        'data_validade',
        'id_user',
        'id_treinamento',
        'id_funcionario',
        'anotacao'

    ];
    public function idUser()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function idTreinamento()
    {
        return $this->belongsTo(Treinamento::class, 'id_treinamento');
    }

    public function idFuncionario()
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }
}