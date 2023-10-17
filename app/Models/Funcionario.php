<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Departamento;
use App\Models\Cargo;
use App\Models\Exame;
use App\Models\Treinamento;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = 'funcionario';
    protected $fillable = [
        'nome',
        'matricula',
        'sexo',
        'RG',
        'CPF',
        'data_nascimento',
        'telefone',
        'email',
        'data_admissao',
        'foto',
        'CEP',
        'logradouro',
        'numero',
        'estado',
        'bairro',
        'cidade',
        'observacao',
        'id_user',
        'id_cargo',
        'id_departamento',
    ];

    public function idUsuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function idCargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo');
    }

    public function idDepartamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }
    public function exames()
    {
        return $this->belongsToMany(Exame::class, 'func_x_exame', 'id_funcionario', 'id_exame', 'id_user')
            ->withPivot('data_validade', 'anotacao');
    }

    public function treinamentos()
    {
        return $this->belongsToMany(Treinamento::class, 'func_x_treinamento', 'id_funcionario', 'id_treinamento', 'id_user')
            ->withPivot('data_validade', 'anotacao');
    }
}
