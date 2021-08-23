<?php

class Api
{

    //datatable
    protected $datatable;
    protected $datatableTh;
    protected $datatableNoSort = [];
    protected $datatableSortDefalt = 0;

    public function dataTable()
    {

        //Post required
        $post = ['draw', 'start', 'length', 'order', 'columns', 'search'];

        //erros
        $erros = [];
        foreach ($post as $name) {
            if (!isset($_POST[$name])) {
                $erros[] = "Enviar post $name";
            }
        }

        //erros return
        if ($erros) {
            exit(json_encode(['erro' => $erros]));
        }

        //Read value
        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        //lista
        $this->setLista();

        //Search 
        $busca = [];
        foreach ($this->datatable as $col => $data) {
            $busca[] = " $data LIKE CONCAT('%',:searchValue,'%') ";
        }
        $searchQuery = '';
        if ($searchValue != '') {
            $searchQuery = " 
                WHERE ( " . implode(' OR ', $busca) . " ) 
            ";
        }

        //Total number of records without filtering
        $totalRecords = $this->Model->all("
            SELECT COUNT(1) AS TOTAL 
              FROM $this->tabela
        ")['dados'][0]['TOTAL'];

        //Total number of record with filtering
        $sql_padrao = "
            SELECT * 
              FROM ({$this->Model->select}) TB 
        ";
        $search_padrao = ($searchQuery ? [':searchValue' => $searchValue] : []);
        $records = $this->Model->all(
            $sql_padrao . $searchQuery,
            $search_padrao
        )['dados'];
        $totalRecordwithFilter = count($records);

        //Fetch records
        $empQuery = "
                     $sql_padrao 
                     $searchQuery
            ORDER BY {$this->datatable[$columnName]} $columnSortOrder 
               LIMIT $row, $rowperpage
        ";
        $empRecords = $this->Model->all(
            $empQuery,
            $search_padrao
        )['dados'];
        $data = [];
        foreach ($empRecords as $id => $row) {
            $data[$id] = [];
            foreach ($this->datatable as $col) {
                $data[$id][] = $row[$col];
            }
            $data[$id][] = "
                <div class='dropdown'>
                    <button class='btn btn-secondary dropdown-toggle' data-bs-toggle='dropdown'></button>
                    <ul class='dropdown-menu' style='padding: 0'>
                        <a class='dropdown-item' style='cursor: pointer' onclick='editar({$row[$this->chave]})'>Editar</a>
                        <a class='dropdown-item' style='cursor: pointer' onclick='excluir({$row[$this->chave]})'>Excluir</a>
                    </ul>
                </div>
            ";
        }

        //Response
        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordwithFilter,
            "data" => $data
        ];

        //return
        exit(json_encode($response));
    }

    public function insert()
    {

        //dados
        $DADOS = $this->getDadosValida($_POST);

        //erros de campo
        if ($DADOS['erros']) {
            exit(json_encode([
                'status' => 0,
                'title' => "Incluir $this->modulo",
                'msg' => 'Verifique os dados',
                'detail' => '<li>' . implode('</li><li>', $DADOS['erros']) . '</li>',
                'campo_erros' => $DADOS['erros']
            ]));
        }
        //sem erros de campo
        else {

            //insert
            $exec =  $this->Model->insert($this->tabela, $DADOS['dados']);

            //erro
            if ($exec['erro']) {
                exit(json_encode([
                    'status' => 0,
                    'title' => "Incluir $this->modulo",
                    'msg' => $this->msg_padrao['execucao'],
                    'detail' => $exec['erro']
                ]));
            }

            //sucesso
            exit(json_encode([
                'status' => 1,
                'title' => "Incluir $this->modulo",
                'msg' => "$this->descricao_singular {$this->msg_padrao['incluir']} com sucesso!",
                'detail' => $this->getMsgLinha($exec['prep']->rowCount())
            ]));
        }
    }

    public function excluir()
    {
        //delete
        $where = [$this->chave => CHAVE];
        $exec =  $this->Model->delete($this->tabela, $where);

        //erro
        if ($exec['erro']) {
            exit(json_encode([
                'status' => 0,
                'title' => "Excluir $this->modulo",
                'msg' => $this->msg_padrao['execucao'],
                'detail' => $exec['erro']
            ]));
        }
        //Não encontrado
        elseif ($exec['prep']->rowCount() == 0) {
            exit(json_encode([
                'status' => 0,
                'title' => "Excluir $this->modulo",
                'msg' => "$this->descricao_singular não {$this->msg_padrao['encontrar']} para excluir",
                'detail' => $this->getMsgLinha(0)
            ]));
        }

        //Sucesso
        exit(json_encode([
            'status' => 1,
            'title' => "Excluir $this->modulo",
            'msg' => "$this->descricao_singular {$this->msg_padrao['excluir']} com sucesso!",
            'detail' => $this->getMsgLinha($exec['prep']->rowCount())
        ]));
    }

    public function editar()
    {
        //all
        $where = [$this->chave => CHAVE];
        $all = $this->Model->list($where);
        $this->Dado = (isset($all['dados'][0]) ? $all['dados'][0] : []);

        //erro
        if ($all['erro']) {
            exit(json_encode([
                'status' => 0,
                'title' => "Editar $this->modulo",
                'msg' => $this->msg_padrao['execucao'],
                'detail' => $all['erro']
            ]));
        }
        //Não encontrado
        elseif (count($this->Dado) == 0) {
            exit(json_encode([
                'status' => 0,
                'title' => "Editar $this->modulo",
                'msg' => "$this->descricao_singular não {$this->msg_padrao['encontrar']} para editar",
                'detail' => $this->getMsgLinha(0, 'encontrar')
            ]));
        }

        //Sucesso
        exit(json_encode([
            'status' => 1,
            'title' => "Editar $this->modulo",
            'msg' => $this->getMsgLinha(0, 'encontrar'),
            'detail' => $this->Dado
        ]));
    }

    public function update()
    {

        //dados
        $DADOS = $this->getDadosValida($_POST);

        //erros de campo
        if ($DADOS['erros']) {
            exit(json_encode([
                'status' => 0,
                'title' => "Alterar $this->modulo",
                'msg' => 'Verifique os dados',
                'detail' => '<li>' . implode('</li><li>', $DADOS['erros']) . '</li>',
                'campo_erros' => $DADOS['erros']
            ]));
        }
        //sem erros de campo
        else {

            //update
            $where = [$this->chave => $_POST[$this->chave]];
            $exec =  $this->Model->update($this->tabela, $DADOS['dados'], $where);

            //erro
            if ($exec['erro']) {
                exit(json_encode([
                    'status' => 0,
                    'title' => "Alterar $this->modulo",
                    'msg' => $this->msg_padrao['execucao'],
                    'detail' => $exec['erro']
                ]));
            }
            //Nada modificado
            elseif ($exec['prep']->rowCount() == 0) {
                exit(json_encode([
                    'status' => 0,
                    'title' => "Alterar $this->modulo",
                    'msg' => "$this->descricao_singular não {$this->msg_padrao['encontrar']} para alterar",
                    'detail' => $this->getMsgLinha(0)
                ]));
            }

            //Sucesso
            exit(json_encode([
                'status' => 1,
                'title' => "Alterar $this->modulo",
                'msg' => "$this->descricao_singular {$this->msg_padrao['alterar']} com sucesso!",
                'detail' => $this->getMsgLinha($exec['prep']->rowCount())
            ]));
        }
    }
}
