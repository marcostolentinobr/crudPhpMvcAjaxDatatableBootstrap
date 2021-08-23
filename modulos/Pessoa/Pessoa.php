<?php

class Pessoa extends Controller
{
    public $descricao = 'Usuários';
    public $descricao_singular = 'Usuário';
    protected $modulo_masculino = true;
    protected $chave = 'PessoaId';
    protected $tabela = 'Pessoa';

    //Cidade
    protected $CidadeDados = [];

    //manutencao
    protected $manutencao = [

        //PrimeiroNome
        'PrimeiroNome' => 'Primeiro Nome|required|trim|max:255|min:3',

        //SegundoNome
        'SegundoNome' => 'Segundo Nome|required|trim|max:255|min:3',

        //Endereco
        'Endereco' => 'Endereço|required|trim|max:255|min:3',

        //CidadeId
        'CidadeId' => 'Cidade|required|numeric',

        //DataNascimento
        'DataNascimento' => 'Nascimento|required|date:Y-m-d',

        //Status
        'Status' => 'Status|required|numeric|max:1|min:1'
    ];

    protected $listagem = [

        //PessoaId
        'PessoaId' => 'Id|width:1%',

        //PrimeiroNome
        'NomeSobrenome' =>  'Nome|sort:default',

        //DataNascimento
        'DataNascimento' => 'Nascimento|sort:no',

        //Endereco
        'Endereco' => 'Endereço',

        //CidadeDesc
        'CidadeDesc' => 'Cidade',

        //StatusDesc
        'Status' => 'Status',
    ];

    protected function view()
    {
        $this->CidadeDados = $this->Model->getList('Cidade');
        parent::view();
    }
}
