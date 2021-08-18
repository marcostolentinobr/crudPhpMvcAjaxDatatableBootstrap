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

    //Estrutura
    protected $estrutura = [

        //PessoaId
        'PessoaId' => [
            'descricao' => 'Id',
            'datatable' => '0'
        ],

        //PrimeiroNome - Manuntenção
        'PrimeiroNome' => [
            'descricao' => 'Primeiro Nome',
            'params'    => 'required|trim|max:255'
        ],

        //PrimeiroNome - Manuntenção
        'NomeSobrenome' => [
            'descricao' => 'Nome',
            'datatable' => '1|default'
        ],

        //SegundoNome - Manuntenção
        'SegundoNome' => [
            'descricao' => 'Segundo Nome',
            'params'    => 'required|trim|max:255'
        ],

        //DataNascimento - Manuntenção
        'DataNascimento' => [
            'descricao' => 'Nascimento',
            'params' => 'required|date:Y-m-d',
            'datatable' => '2|no-sort'
        ],

        //Endereco - Manuntenção
        'Endereco' => [
            'descricao' => 'Endereço',
            'params'    => 'required|trim|max:255',
            'datatable' => '3'
        ],

        //CidadeDesc
        'CidadeDesc' => [
            'descricao' => 'Cidade',
            'datatable' => '4'
        ],

        //CidadeId - Manuntenção
        'CidadeId' => [
            'descricao' => 'Cidade',
            'params'    => 'required|numeric'
        ],

        //Status - Manuntenção
        'Status' => [
            'descricao' => 'Status',
            'params'    => 'required|numeric|max:1'
        ],

        //StatusDesc
        'StatusDesc' => [
            'descricao' => 'Status',
            'datatable' => '5'
        ]
    ];

    public function list()
    {
        $this->CidadeDados = $this->Model->getCidades();
        parent::list();
    }

}
