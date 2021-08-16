<?php

class PessoaModel extends Model
{

    protected $select = "
        SELECT 
        
               -- usuario 
               P.PessoaId,
               P.PrimeiroNome,
               P.SegundoNome,
               P.DataNascimento,
               P.Endereco,
               
               -- status
               P.Status,
               CASE WHEN P.Status = '1' THEN 'Ativo' 
                    ELSE 'Inativo' 
               END AS StatusDesc,

               -- cidade
               P.CidadeId,
               C.CidadeDesc

          FROM Pessoa P
          JOIN Cidade C
            ON C.CidadeId = P.CidadeId
    ";

    protected $select_edit = '
        SELECT     
               
               -- usuario 
               P.PessoaId,
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
