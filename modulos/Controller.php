<?php

class Controller extends Api
{
    //Parametros
    protected $modulo;
    protected $acao = 'insert';
    protected $msg;
    protected $msg_padrao = [];

    //Para edição
    protected $Dado = [];

    //Para listagem
    protected $Dados = [];

    //Instancia
    protected $Model;

    public function __construct()
    {

        //Modulo
        $this->modulo = get_called_class();

        //Model
        $model = $this->modulo . 'Model';
        $this->Model = new $model();

        //Msg
        $this->setMsgPadrao();

        if (!METODO) {
            $this->list();
        }
    }

    public function list()
    {
        //all
        $all =  $this->Model->list();
        $this->Dados = $all['dados'];

        //erro
        if ($all['erro']) {
            $this->setMsg($this->msg_padrao['execucao'], 'danger', $all['erro']);
        }

        //dado
        $this->setDado();

        //lista
        $this->setLista();

        //View
        $this->addPagina('form');
        require_once RAIZ . "/modulos/_paginas/template.php";
    }

    public function insert()
    {

        //dados
        $DADOS = $this->getDadosValida($_POST);

        //erros de campo
        if ($DADOS['erros']) {
            $msg = '<li>' . implode('<li>', $DADOS['erros']);
            $style = 'danger';
            $obs = 'Verifique os dados';
        }
        //sem erros de campo
        else {

            //exec
            $exec =  $this->Model->insert($this->tabela, $DADOS['dados']);

            //erro
            if ($exec['erro']) {
                $msg = $this->msg_padrao['execucao'];
                $style = 'danger';
                $obs = $exec['erro'];
            }
            //sucesso
            else {
                $msg = "$this->descricao_singular {$this->msg_padrao['incluir']} com sucesso!";
                $style = 'success';
                $obs = $this->getMsgLinha($exec['prep']->rowCount());
            }
        }

        //list
        $this->setMsg($msg, $style, $obs);
        $this->list();
    }

    public function update()
    {

        //dados
        $DADOS = $this->getDadosValida($_POST);

        //erros de campo
        if ($DADOS['erros']) {
            $msg = '<li>' . implode('<li>', $DADOS['erros']);
            $style = 'danger';
            $obs = 'Verifique os dados';
        } else {

            //update
            $where = [$this->chave => $_POST[$this->chave]];
            $exec =  $this->Model->update($this->tabela, $DADOS['dados'], $where);

            //erro
            if ($exec['erro']) {
                $this->setMsg($this->msg_padrao['execucao'], 'danger', $exec['erro']);
            }
            //Nada modificado
            elseif ($exec['prep']->rowCount() == 0) {
                $msg = "$this->descricao_singular não {$this->msg_padrao['alterar']}, nada modificado.";
                $style = 'danger';
                $obs = $this->getMsgLinha(0);
            }
            //Sucesso
            else {
                $msg = "$this->descricao_singular {$this->msg_padrao['alterar']} com sucesso!";
                $style = 'success';
                $obs = $this->getMsgLinha($exec['prep']->rowCount());
            }
        }

        //list
        $this->setMsg($msg, $style, $obs);
        $this->list();
    }

    //mensagem 
    public function setMsg($msg, $style, $obs)
    {
        $this->msg = " 
            <div class='alert alert-$style'>
                $msg<br>
                <small style='font-size: 10px; color: silver'>$obs</small>
            </div>
        ";
    }

    protected function setDado()
    {
        $this->Dado[$this->chave] = isset($this->Dado[$this->chave]) ? $this->Dado[$this->chave] : '';
        foreach ($this->manutencao as $col => $data) {
            $data = explode('|', $data);
            $this->Dado[$col] = isset($this->Dado[$col]) ? $this->Dado[$col] : '';
        }
    }

    protected function setLista()
    {
        $ordem = 0;
        foreach ($this->listagem as $col => $data) {
            $data = explode('|', $data);

            $style = [];
            foreach ($data as $dt) {

                //sort
                if (substr($dt, 0, 4) == 'sort') {
                    $sort = explode(':', $dt)[1];

                    //sort no
                    if ($sort == 'no') {
                        $this->datatableNoSort[] = $ordem;
                    }

                    //sort default
                    if ($sort == 'default') {
                        $this->datatableSortDefalt = $ordem;
                    }
                }

                if (substr($dt, 0, 5) == 'width') {
                    $style[] = $dt;
                }
            }

            $this->datatable[] = $col;
            $this->datatableTh .= "<th style='" . implode(', ', $style) . "'>$data[0]</th>";
            $ordem++;
        }


        $this->datatableNoSort[] = count($this->datatable);
        $this->datatableTh .= "<th style='width: 1%'>Ações</th>";
    }

    protected function getMsgLinha($number, $msg_padrao = 'afetar')
    {
        if ($number <= 1) {
            return "$number $this->descricao_singular {$this->msg_padrao[$msg_padrao]}";
        }
        return "$number $this->descricao {$this->msg_padrao[$msg_padrao]}s";
    }

    protected function getDadosValida($DADOS)
    {
        $erros = [];
        $campo = [];

        foreach ($this->manutencao as $col => $data) {
            $data = explode('|', $data);

            $campo[$col] = isset($DADOS[$col]) ? $DADOS[$col] : null;
            $campoValor = reticencias(trim($campo[$col]), 10);
            foreach ($data as $param) {

                //required
                if ($param == 'required' && empty(trim($campo[$col]))) {
                    $erros[] = "Campo '$data[0]' é obrigatório";
                    break;
                }

                //trim
                if ($param == 'trim') {
                    $campo[$col] = trim($campo[$col]);
                }

                //number
                if ($param == 'numeric' && !is_numeric($campo[$col])) {
                    $erros[] = "Campo '$data[0]' ($campoValor) precisa ser numérico";
                }

                //max
                if (substr($param, 0, 3) == 'max') {
                    $max = explode(':', $param)[1];
                    if (strlen($campo[$col]) > $max) {
                        $erros[] = "Campo '$data[0]' ($campoValor) é maior que o permitido. Informe até $max caractere(s).";
                    }
                }

                //min
                if (substr($param, 0, 3) == 'min') {
                    $min = explode(':', $param)[1];
                    if (strlen($campo[$col]) < $min) {
                        $erros[] = "Campo '$data[0]' ($campoValor) é menor que o permitido. Informe no mínimo $min caractere(s).";
                    }
                }

                //date
                if (substr($param, 0, 4) == 'date') {
                    $dateFormat = explode(':', $param)[1];
                    if (!dataValida($campo[$col], $dateFormat)) {
                        $erros[] = "Campo '$data[0][descricao]' ($campoValor) não é uma data válida. Defina no formato $dateFormat.";
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

        if ($this->modulo_masculino) {
            $this->msg_padrao['incluir'] = 'incluído';
            $this->msg_padrao['alterar'] = 'alterado';
            $this->msg_padrao['encontrar'] = 'encontrado';
            $this->msg_padrao['excluir'] = 'excluído';
            $this->msg_padrao['afetar'] = 'afetado';
        } else {
            $this->msg_padrao['incluir'] = 'incluída';
            $this->msg_padrao['alterar'] = 'alterada';
            $this->msg_padrao['encontrar'] = 'encontrada';
            $this->msg_padrao['excluir'] = 'excluída';
            $this->msg_padrao['afetar'] = 'afetada';
        }
    }
}
