<?php

class Conexao extends PDO
{
    protected $Pdo;

    function __construct($dbname, $driver, $host, $user, $pass, $charset)
    {
        $this->Pdo = parent::__construct(
            "$driver:host=$host;dbname=$dbname;charset=$charset",
            $user,
            $pass
        );

        return $this->Pdo;
    }

    public function all($qry, $params = [], $fetch = PDO::FETCH_ASSOC)
    {
        $prepExec = $this->prepExec($qry, $params);

        $return = [
            'dados' => $prepExec['prep']->fetchAll($fetch)
        ];

        return array_merge($return, $prepExec);
    }

    public function insert($tabela, $valores)
    {
        $dados = $this->dadosQry($valores, true);
        $insert = "INSERT INTO $tabela  ( " . implode(", ", $dados['col']);
        $insert .= ') VALUES ( :' . implode(", :", $dados['col']) . ')';
        return $this->prepExec($insert,  $valores);
    }

    public function delete($tabela, $where)
    {
        $dadoswhere = $this->dadosQry($where, false);
        $delete = "DELETE FROM $tabela ";
        $delete .= ' WHERE ' . implode(' AND ', $dadoswhere['col']);
        return $this->prepExec($delete, $where);
    }

    public function update($tabela, $valores, $where)
    {
        $dados = $this->dadosQry($valores, false);
        $dadosWhere = $this->dadosQry($where, false);
        $delete = "UPDATE $tabela SET " . implode(", ", $dados['col']);
        $delete .= ' WHERE ' . implode(' AND ', $dadosWhere['col']);
        return $this->prepExec($delete, array_merge($valores, $where));
    }

    public function prepExec($qry, $params = [])
    {
        $exec = null;
        $erro = null;

        try {
            $prep = $this->prepare($qry);
            $exec = $prep->execute($params);
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }

        return [
            'prep' => $prep,
            'exec' => $exec,
            'erro' => $erro
        ];
    }

    protected function dadosQry($dados, $insert = false)
    {
        $ITEM = [];
        $ITEM['col'] = [];
        $ITEM['val'] = [];
        foreach ($dados as $coluna => $valor) {
            if ($insert) {
                $ITEM['col'][] = "$coluna";
            } else {
                $ITEM['col'][] = "$coluna=:$coluna";
            }
            $key = ":$coluna";
            $ITEM['val'][$key] = $valor;
        }
        return $ITEM;
    }
}
