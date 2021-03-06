<?php

class PessoaModel extends Model
{

    public $select = "
        SELECT P.PessoaId,
               CONCAT(P.PrimeiroNome,' ',P.SegundoNome) AS NomeSobrenome,
               DATE_FORMAT(P.DataNascimento, '%d/%m/%Y') AS DataNascimento,
               P.Endereco,
               CASE WHEN P.Status = '1' THEN 'Ativo' ELSE 'Inativo' END AS Status,
               C.CidadeDesc
          FROM Pessoa P
          JOIN Cidade C
            ON C.CidadeId = P.CidadeId
      ORDER BY NomeSobrenome
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
}
