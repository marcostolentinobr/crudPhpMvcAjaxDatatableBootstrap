<?php

class ProjetoModel extends Model
{

    public $select = "
        SELECT P.id,
               P.nome,
               DATE_FORMAT(P.data_fim, '%d/%m/%Y') AS data_fim,
               DATE_FORMAT(A.atividade_fim_max, '%d/%m/%Y') AS atividade_fim_max,
               A.qtd,
               A.concluido_qtd, 
               (A.qtd - A.concluido_qtd) AS falta_qtd,
               ((A.concluido_qtd * 100) / A.qtd) AS concluido_por,
               CASE WHEN A.qtd IS NULL                    THEN '0 atividades'
                    WHEN (A.qtd - A.concluido_qtd) = 0    THEN 'Concluído'
                    WHEN A.atividade_fim_max > P.data_fim THEN 'Sim' 
                    ELSE 'Não' 
               END AS atrasara
          FROM PROJETO P 
     LEFT JOIN (     
                    SELECT A.projeto_id,
                           MAX(A.data_fim) as atividade_fim_max,
                           COUNT(1) AS qtd,
                           SUM(CASE WHEN A.data_concluido IS NOT NULL THEN 1 ELSE 0 END) AS concluido_qtd
                      FROM ATIVIDADE A
                  GROUP BY A.projeto_id
                ) A
            ON A.projeto_id = P.id
    ";

    protected $select_edit = '
        SELECT P.id,
               P.nome,
               P.data_fim
          FROM PROJETO P
         WHERE P.id = :id
    ';

    public function getNumeros()
    {

        $qry = "
            SELECT COUNT(1) AS qtd, 
                   (SUM(CASE WHEN concluido_por = 100 OR concluido_por IS NULL THEN 1 ELSE 0 END) * 100) / COUNT(1) AS concluido_por 
              FROM ( $this->select ) TB 
        ";

        return $this->all($qry);
    }
}
