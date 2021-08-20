<?php
require_once __DIR__ . '/../config.php';

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
