<?php

class Projeto extends Controller
{
    protected $descricao = 'Projetos';
    protected $descricao_singular = 'Projeto';
    protected $modulo_masculino = true;
    protected $chave = 'id';
    protected $tabela = 'PROJETO';

    //manutencao
    protected $manutencao = [

        //nome
        'nome' => 'Projeto|required|trim|max:50|min:3',

        //data_fim
        'data_fim' => 'Fim|required|date:Y-m-d'

    ];

    protected $listagem = [

        //nome
        'nome' => 'Projeto|sort:default',

        //data_fim
        'data_fim' => 'Fim|sort:no',

        //atividade_fim_max
        'atividade_fim_max' => 'Última atividade|sort:no',

        //qtd
        'qtd' => 'Qtd Atividade',

        //concluido_qtd
        'concluido_qtd' => 'Qtd concluída',

        //falta_qtd
        'falta_qtd' => 'Qtd faltante',

        //falta_qtd
        'concluido_por' => 'Concluído(%)',

        //atrasara
        'atrasara' => 'Atrasará?'
    ];

    protected function view()
    {
        //form
        $this->setDado();
        $this->addPagina('form');

        //View
        $this->setLista();

        //cabecalho
        require_once RAIZ . '/modulos/_paginas/template_cabecalho.php';

        //numeros
        $this->addPagina('numeros');

        //datatable
        require_once RAIZ . '/modulos/_paginas/template_datatable.php';

        //acao
        require_once RAIZ . '/modulos/_paginas/template_acao.php';
    }

    public function numeros()
    {
        exit(json_encode([
            'status' => 1,
            'title'  => "Números $this->modulo",
            'msg'    => "$this->descricao retornados com sucesso!",
            'detail' => $this->Model->getNumeros()['dados'][0]
        ]));
    }
}
