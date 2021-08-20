<?php

class Api
{
    public function dados()
    {

        //all
        $where = [$this->chave => CHAVE];
        $all = $this->Model->list($where);
        $this->Dado = (isset($all['dados'][0]) ? $all['dados'][0] : []);

        //erro
        if ($all['erro']) {
            exit(json_encode(['erro' => [$all['erro']]]));
        }

        //list
        exit(json_encode($this->Dado));
    }

    public function dataTable()
    {

        //dados
        $this->setDado();

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

        ## Read value
        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        ## Search 
        $busca = [];
        foreach ($this->datatable as $col) {
            $busca[] = " $col LIKE CONCAT('%',:searchValue,'%') ";
        }
        $searchQuery = '';
        if ($searchValue != '') {
            $searchQuery = " 
                WHERE ( " . implode(' OR ', $busca) . " ) 
            ";
        }

        ## Total number of records without filtering
        $totalRecords = $this->Model->all("
            SELECT COUNT(1) AS TOTAL 
              FROM $this->tabela
        ")['dados'][0]['TOTAL'];

        ## Total number of record with filtering
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

        ## Fetch records
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
                        <a class='dropdown-item' href='$this->modulo/edit/{$row[$this->chave]}'>Editar</a>
                        <a class='dropdown-item' href='$this->modulo/delete/{$row[$this->chave]}'>Excluir</a>
                    </ul>
                </div>
            ";
        }
        // <li><hr class='dropdown-divider'></li>

        ## Response
        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordwithFilter,
            "data" => $data
        ];

        exit(json_encode($response));
    }
}
