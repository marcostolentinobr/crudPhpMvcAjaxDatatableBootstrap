<?php

class PessoaModel extends Model
{

    public $select = "
        SELECT P.PessoaId,
               CONCAT(P.PrimeiroNome,' ',P.SegundoNome) AS NomeSobrenome,
               DATE_FORMAT(P.DataNascimento, '%d/%m/%Y') AS DataNascimento,
               P.Endereco,
               CASE WHEN P.Status = '1' THEN 'Ativo' 
                                        ELSE 'Inativo' 
               END AS StatusDesc,
               C.CidadeDesc
          FROM Pessoa P
          JOIN Cidade C
            ON C.CidadeId = P.CidadeId
    ";

    protected $select_edit = '
        SELECT P.PessoaId,
               P.PrimeiroNome,
               P.SegundoNome,
               P.DataNascimento,
               P.Endereco,
               P.Status,
               P.CidadeId
            FROM Pessoa P
           WHERE P.PessoaId = :PessoaId
    ';

    public function getCidades()
    {
        require_once __DIR__ . '/../Cidade/CidadeModel.php';
        $ModelCidade = new CidadeModel();
        return $ModelCidade->list()['dados'];
    }
}
