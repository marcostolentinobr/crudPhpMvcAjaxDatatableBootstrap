<?php

class Pessoa extends Controller
{
    protected $descricao = 'Usuários';
    protected $descricao_singular = 'Usuário';
    protected $modulo_masculino = false;
    protected $chave = 'PessoaId';
    protected $tabela = 'Pessoa';

    //Cidade
    protected $CidadeDados = [];

    protected $permitido = [

        //PrimeiroNome
        'PrimeiroNome' => [
            'descricao' => 'Primeiro Nome',
            'params'    => 'required|trim|max:255'
        ],

        //SegundoNome
        'SegundoNome' => [
            'descricao' => 'Segundo Nome',
            'params'    => 'required|trim|max:255'
        ],

        //Endereco
        'Endereco' => [
            'descricao' => 'Endereço',
            'params'    => 'required|trim|max:255'
        ],

        //CidadeId
        'CidadeId' => [
            'descricao' => 'Cidade',
            'params'    => 'required|numeric'
        ],

        //DataNascimento
        'DataNascimento' => [
            'descricao' => 'Data de nascimento',
            'params' => 'required|date:Y-m-d'
        ],

        //Status
        'Status' => [
            'descricao' => 'Status',
            'params'    => 'required|numeric|max:1'
        ],
    ];

    public function list(){
        $this->CidadeDados = $this->Model->getCidades();
        parent::list();
    }
    
}
