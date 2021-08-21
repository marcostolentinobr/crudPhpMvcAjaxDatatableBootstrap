<!-- bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jquery -->
<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>

<!-- datatable -->
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css'>
<script src='https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js'></script>

<!-- modal msg -->
<div class="modal fade" id="modal_msg" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <!-- title -->
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- body -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim modal msg -->

<?php

//Model
$fileModel = RAIZ . '/modulos/' . CLASSE . '/' . CLASSE . 'Model.php';
if (file_exists($fileModel)) {
    require_once RAIZ . '/modulos/Model.php';
    require_once $fileModel;
}

//Controller
$fileControler = RAIZ . '/modulos/' . CLASSE . '/' . CLASSE . '.php';
if (file_exists($fileControler)) {
    require_once RAIZ . '/modulos/Api.php';
    require_once RAIZ . '/modulos/Controller.php';
    require_once $fileControler;
}

//Classe
$Classe = CLASSE;
if (class_exists($Classe)) {
    $Classe = new $Classe();

    //Metodo
    $Metodo = METODO;
    if (method_exists($Classe, $Metodo)) {
        $Classe->$Metodo();
    }
}
//Não existe classe
else {
    header('Location: Pessoa/list');
}
