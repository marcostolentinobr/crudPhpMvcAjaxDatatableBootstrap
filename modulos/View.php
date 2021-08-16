<?php

//Model
$fileModel = __DIR__ . '/' . CLASSE . '/' . CLASSE . 'Model.php';
if (file_exists($fileModel)) {
    require_once __DIR__ . '/Model.php';
    require_once $fileModel;
}

//Controller
$fileControler = __DIR__ . '/' . CLASSE . '/' . CLASSE . '.php';
if (file_exists($fileControler)) {
    require_once __DIR__ . '/Controller.php';
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
