<?php

class Controller
{
    //Parametros
    protected $modulo;
    protected $acao = 'insert';
    protected $acao_descricao = 'Incluir';
    protected $msg;
    protected $msg_padrao = [];

    //Para edição
    protected $Dado = [];

    //Para listagem
    protected $Dados = [];

    //Instancia
    protected $Model;

    //datatable
    protected $datatable;
    protected $datatableTh;
    protected $datatableNoSort = [];
    protected $datatableSortDefalt = 0;

    public function __construct()
    {

        //Modulo
        $this->modulo = get_called_class();

        //Model
        $model = $this->modulo . 'Model';
        $this->Model = new $model();

        //Msg
        $this->setMsgPadrao();
    }

    public function list()
    {
        //all
        $all =  $this->Model->list();
        $this->Dados = $all['dados'];

        //erro
        if ($all['erro']) {
            $this->setMsg($this->msg_padrao['execucao'], 'red', $all['erro']);
        }

        //dado
        $this->setDado();

        //View
        require_once RAIZ . "/modulos/$this->modulo/{$this->modulo}View.php";
    }

    public function insert()
    {

        //dados
        $DADOS = $this->getDadosValida($_POST);

        //erros de campo
        if ($DADOS['erros']) {
            $msg = '<li>' . implode('<li>', $DADOS['erros']);
            $cor = 'red';
            $obs = 'Verifique os dados';
        }
        //sem erros de campo
        else {

            //exec
            $exec =  $this->Model->insert($this->tabela, $DADOS['dados']);

            //erro
            if ($exec['erro']) {
                $msg = $this->msg_padrao['execucao'];
                $cor = 'red';
                $obs = $exec['erro'];
            }
            //sucesso
            else {
                $msg = "$this->descricao_singular {$this->msg_padrao['incluir']} com sucesso!";
                $cor = 'green';
                $obs = $this->getMsgLinhaAfetada($exec['prep']->rowCount());
            }
        }

        //list
        $this->setMsg($msg, $cor, $obs);
        $this->list();
    }



    public function delete()
    {

        //delete
        $where = [$this->chave => CHAVE];
        $exec =  $this->Model->delete($this->tabela, $where);

        //erro
        if ($exec['erro']) {
            $this->setMsg($this->msg_padrao['execucao'], 'red', $exec['erro']);
        }
        //Não encontrado
        elseif ($exec['prep']->rowCount() == 0) {
            $this->setMsg(
                "$this->descricao_singular não {$this->msg_padrao['encontrar']} para excluir",
                'red',
                $this->msg_padrao['nenhuma']
            );
        }
        //Sucesso
        else {
            $this->setMsg(
                "$this->descricao_singular {$this->msg_padrao['excluir']} com sucesso!",
                'green',
                $this->getMsgLinhaAfetada($exec['prep']->rowCount())
            );
        }

        //list
        $this->list();
    }

    public function edit()
    {

        //all
        $where = [$this->chave => CHAVE];
        $all = $this->Model->list($where);
        $this->Dado = (isset($all['dados'][0]) ? $all['dados'][0] : []);

        //erro
        if ($all['erro']) {
            $this->setMsg($this->msg_padrao['execucao'], 'red', $all['erro']);
        }
        //Não encontrado
        elseif (count($this->Dado) == 0) {
            $this->setMsg(
                "$this->descricao_singular não {$this->msg_padrao['encontrar']} para editar",
                'red',
                $this->msg_padrao['nenhuma']
            );
        }
        //Sucesso
        else {
            //Params
            $this->acao = 'update';
            $this->acao_descricao = 'Alterar';
        }

        //list
        $this->list();
    }

    public function update()
    {

        //dados
        $DADOS = $this->getDadosValida($_POST);

        //erros de campo
        if ($DADOS['erros']) {
            $msg = '<li>' . implode('<li>', $DADOS['erros']);
            $cor = 'red';
            $obs = 'Verifique os dados';
        } else {

            //update
            $where = [$this->chave => $_POST[$this->chave]];
            $exec =  $this->Model->update($this->tabela, $DADOS['dados'], $where);

            //erro
            if ($exec['erro']) {
                $this->setMsg($this->msg_padrao['execucao'], 'red', $exec['erro']);
            }
            //Nada modificado
            elseif ($exec['prep']->rowCount() == 0) {
                $msg = "$this->descricao_singular não {$this->msg_padrao['alterar']}, nada modificado.";
                $cor = 'red';
                $obs = $this->msg_padrao['nenhuma'];
            }
            //Sucesso
            else {
                $msg = "$this->descricao_singular {$this->msg_padrao['alterar']} com sucesso!";
                $cor = 'green';
                $obs = $this->getMsgLinhaAfetada($exec['prep']->rowCount());
            }
        }

        //list
        $this->setMsg($msg, $cor, $obs);
        $this->list();
    }

    //mensagem 
    public function setMsg($msg, $cor, $obs)
    {
        $this->msg = " 
            <h4 style='color: $cor'>
                $msg<br>
                <small style='font-size: 10px; color: silver'>$obs</small>
            </h4>
        ";
    }

    protected function setDado()
    {
        $this->Dado[$this->chave] = isset($this->Dado[$this->chave]) ? $this->Dado[$this->chave] : '';
        foreach ($this->estrutura as $col => $dados) {

            if (isset($dados['datatable'])) {
                $dt = explode('|', $dados['datatable']);
                $order = $dt[0];

                foreach ($dt as $param) {
                    if ($param == 'no-sort') {
                        $this->datatableNoSort[] = $order;
                    }
                    if ($param == 'default') {
                        $this->datatableSortDefalt = $order;
                    }
                }

                //defalt
                if (isset($dt[2])) {
                    $this->datatableSortDefalt = $order;
                }

                $this->datatable[$order] = $col;
                $this->datatableTh .= "<th>$dados[descricao]</th>";
            }

            //Manutenção
            if (isset($dados['params'])) {
                $this->Dado[$col] = isset($this->Dado[$col]) ? $this->Dado[$col] : '';
            }
        }
        $this->datatableNoSort[] = count($this->datatable);
        $this->datatableTh .= "<th>Ações</th>";
    }

    protected function getMsgLinhaAfetada($number)
    {
        return "$number linhas afetada(s)";
    }

    protected function getDadosValida($DADOS)
    {
        $erros = [];
        $campo = [];

        foreach ($this->estrutura as $col => $dados) {

            //Sem params não é para manutenção
            if (!isset($dados['params'])) {
                continue;
            }

            $params = explode('|', $dados['params']);
            $campo[$col] = isset($DADOS[$col]) ? $DADOS[$col] : null;
            $campoValor = reticencias(trim($campo[$col]), 10);
            foreach ($params as $param) {

                //required
                if ($param == 'required' && empty(trim($campo[$col]))) {
                    $erros[] = "Campo '$dados[descricao]' é obrigatório";
                    break;
                }

                //trim
                if ($param == 'trim') {
                    $campo[$col] = trim($campo[$col]);
                }

                //number
                if ($param == 'numeric' && !is_numeric($campo[$col])) {
                    $erros[] = "Campo '$dados[descricao]' ($campoValor) precisa ser numérico";
                }

                //max
                if (substr($param, 0, 3) == 'max') {
                    $max = explode(':', $param)[1];
                    if (strlen($campo[$col]) > $max) {
                        $erros[] = "Campo '$dados[descricao]' ($campoValor) é maior que o permitido. Informe até $max caracteres.";
                    }
                }

                //date
                if (substr($param, 0, 4) == 'date') {
                    $dateFormat = explode(':', $param)[1];
                    if (!dataValida($campo[$col], $dateFormat)) {
                        $erros[] = "Campo '$dados[descricao]' ($campoValor) não é uma data válida. Defina no formato $dateFormat.";
                    }
                }
            }
        }

        return [
            'dados' => $campo,
            'erros' => $erros
        ];
    }

    private function addPagina($pagina)
    {
        require_once RAIZ . "/modulos/$this->modulo/paginas/" . strtolower($this->modulo) . "_$pagina.php";
    }

    private function setMsgPadrao()
    {
        $this->msg_padrao['execucao'] = 'Não executou! Tente novamente. Se persistir entre em contato.';
        $this->msg_padrao['nenhuma'] = 'Nenhuma linha encontrada.';

        if ($this->modulo_masculino) {
            $this->msg_padrao['incluir'] = 'incluído';
            $this->msg_padrao['alterar'] = 'alterado';
            $this->msg_padrao['encontrar'] = 'encontrado';
            $this->msg_padrao['excluir'] = 'excluído';
        } else {
            $this->msg_padrao['incluir'] = 'incluída';
            $this->msg_padrao['alterar'] = 'alterada';
            $this->msg_padrao['encontrar'] = 'encontrada';
            $this->msg_padrao['excluir'] = 'excluída';
        }
    }

    public function dataTable()
    {
        $this->setDado();

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
                <a href='$this->modulo/edit/{$row[$this->chave]}'>Editar</a>
                <a href='$this->modulo/delete/{$row[$this->chave]}'>Excluir</a>
            ";
        }

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
