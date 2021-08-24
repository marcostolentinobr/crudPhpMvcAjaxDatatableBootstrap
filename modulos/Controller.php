<?php

class Controller extends Api
{
    protected $modulo;
    protected $Dado = [];
    protected $Dados = [];
    protected $Model;

    //msg_padrao
    protected $msg_padrao = [
        'execucao' => 'Não executou! Tente novamente. Se persistir entre em contato.'
    ];

    public function __construct()
    {

        //Modulo
        $this->modulo = get_called_class();

        //ModelMODULO_INICIAL
        $model = $this->modulo . 'Model';
        $this->Model = new $model();

        //Msg
        if (isset($this->modulo_masculino)) {
            $this->setMsgPadrao();
        }

        //Sem método ir para view
        if (!METODO) {
            $this->view();
        }
    }

    protected function view()
    {
        //dado
        $this->setDado();

        //lista
        $this->setLista();

        //View
        $this->addPagina('form');
        require_once RAIZ . "/modulos/_paginas/template.php";
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

                //style width
                if (substr($dt, 0, 5) == 'width') {
                    $style[] = $dt;
                }
            }

            $this->datatable[] = $col;
            $this->datatableTh .= "<th style='" . implode(', ', $style) . "'>$data[0]</th>";
            $ordem++;
        }

        $this->datatableNoSort[] = count($this->datatable);
        $this->datatableTh .= "<th style='width: 1%'></th>";
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

                //empty
                if (empty(trim($campo[$col]))) {
                    $campo[$col] = null;
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

    protected function addPagina($pagina)
    {
        require_once RAIZ . "/modulos/$this->modulo/paginas/" . strtolower($this->modulo) . "_$pagina.php";
    }

    private function setMsgPadrao()
    {
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
