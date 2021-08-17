<?php

class Pessoa extends Controller
{
    protected $descricao = 'Usuários';
    protected $descricao_singular = 'Usuário';
    protected $modulo_masculino = false;
    protected $chave = 'PessoaId';
    protected $tabela = 'Pessoa';

    //Cidade
    protected $CidadeDados = [];

    protected $permitido = [

        //PrimeiroNome
        'PrimeiroNome' => [
            'descricao' => 'Primeiro Nome',
            'params'    => 'required|trim|max:255'
        ],

        //SegundoNome
        'SegundoNome' => [
            'descricao' => 'Segundo Nome',
            'params'    => 'required|trim|max:255'
        ],

        //Endereco
        'Endereco' => [
            'descricao' => 'Endereço',
            'params'    => 'required|trim|max:255'
        ],

        //CidadeId
        'CidadeId' => [
            'descricao' => 'Cidade',
            'params'    => 'required|numeric'
        ],

        //DataNascimento
        'DataNascimento' => [
            'descricao' => 'Data de nascimento',
            'params' => 'required|date:Y-m-d'
        ],

        //Status
        'Status' => [
            'descricao' => 'Status',
            'params'    => 'required|numeric|max:1'
        ],
    ];

    public function list()
    {
        $this->CidadeDados = $this->Model->getCidades();
        parent::list();
    }

    public function dataTable()
    {

        $col = [
            'PessoaId',
            'PrimeiroNome',
            'DataNascimento',
            'Endereco',
            'CidadeDesc',
            'Status'
        ];

        ## Read value
        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        ## Search 
        $searchQuery = " ";
        if ($searchValue != '') {
            $searchQuery = " 
                WHERE 
                      (    P.PrimeiroNome LIKE '%" . $searchValue . "%'  
                        OR P.SegundoNome LIKE '%" . $searchValue . "%'  
                        OR P.Endereco LIKE '%" . $searchValue . "%'  
                        OR C.CidadeDesc LIKE '%" . $searchValue . "%'  
                        OR DATE_FORMAT(P.DataNascimento, '%d/%m/%Y') LIKE '%" . $searchValue . "%'  
                        OR CASE WHEN P.Status = '1' THEN 'Ativo' ELSE 'Inativo' END LIKE '%" . $searchValue . "%'  
                      ) 
            ";
        }

        ## Total number of records without filtering
        $totalRecords = count($this->Model->list()['dados']);

        ## Total number of record with filtering
        $records = $this->Model->all(
            $this->Model->select . "
                $searchQuery
            "
        )['dados'];
        $totalRecordwithFilter = count($records);

        ## Fetch records
        $empQuery = "
            {$this->Model->select} 
            $searchQuery 
            ORDER BY $col[$columnName] $columnSortOrder LIMIT $row, $rowperpage
        ";
        //pr($empQuery);
        
        $empRecords = $this->Model->all($empQuery)['dados'];
        $data = [];

        foreach ($empRecords as $row) {
            $data[] = [
                $row['PessoaId'],
                "$row[PrimeiroNome] $row[SegundoNome]",
                $row['DataNascimento'],
                $row['Endereco'],
                $row['CidadeDesc'],
                $row['Status'],
                "
                    <a href='$this->modulo/edit/$row[PessoaId]'>Editar</a>
                    <a href='$this->modulo/delete/$row[PessoaId]'>Excluir</a>
                "
            ];
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
