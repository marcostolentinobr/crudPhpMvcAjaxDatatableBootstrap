<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

//BD
define('DB_NAME', 'EUAX');
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

//TITULO
define('TITULO', 'EUAX');

//MODULO_INICIAL
define('MODULO_INICIAL', 'Projeto');

//Functions
require_once __DIR__ . '/libs/functions.php';

//init
init();

//Menu
define('MENU', [
    URL . 'Projeto'   => 'Projetos',
    URL . 'Atividade' => 'Atividades',
]);
