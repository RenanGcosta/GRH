<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Exame;
use App\Models\Funcionario;

class FuncionarioExame extends Model
{
    use HasFactory;
    protected $table = 'func_x_exame';
    protected $fillable = [
        'data_validade',
        'id_user',
        'id_exame',
        'id_funcionario',
        'anotacao',

    ];
    public function idUser()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function idExame()
    {
        return $this->belongsTo(Exame::class, 'id_exame');
    }

    public function idFuncionario()
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }
    
}
