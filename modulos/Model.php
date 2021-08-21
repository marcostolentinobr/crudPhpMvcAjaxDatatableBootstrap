<?php
require_once RAIZ . '/libs/Conexao.php';
class Model extends Conexao
{
    public function __construct()
    {
        parent::__construct(DB_NAME, DB_DRIVER, DB_HOST, DB_USER, DB_PASS, DB_CHARSET);
    }

    public function list($where = [])
    {
        if ($where) {
            return $this->all($this->select_edit, $where);
        }

        return $this->all($this->select);
    }

    public function instancia($modulo)
    {
        require_once RAIZ . "/modulos/$modulo/{$modulo}Model.php";
        $Model = "{$modulo}Model";
        return new $Model();
    }

    public function getList($modulo)
    {
        $Model = $this->instancia($modulo);
        return $Model->list()['dados'];
    }
}
