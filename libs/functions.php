<?php

//show parametro
function pr($str)
{
  echo '<pre>';
  print_r($str);
  echo '</pre>';
}

//Inicía projeto
function init()
{

  //URL
  $url = [];
  if (isset($_GET['pg'])) {
    $url = explode('/', $_GET['pg']);
  }
  define('CLASSE', isset($url[0]) ? $url[0] : '');
  define('METODO', isset($url[1]) ? $url[1] : '');
  define('CHAVE', isset($url[2]) ? $url[2] : '');

  //RAIZ
  define('RAIZ', str_replace('/libs', '', str_replace('\libs', '', __DIR__)));

  //URL
  $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
  define('URL', $url);
}

//data validade
function dataValida($date, $format = 'Y-m-d H:i:s')
{
  $d = DateTime::createFromFormat($format, $date);
  return $d && $d->format($format) == $date;
}

//reticencias
function reticencias($descricao, $tamanhoMaximo)
{
  if (strlen($descricao) > $tamanhoMaximo) {
    return substr($descricao, 0, $tamanhoMaximo) . '...';
  }
  return $descricao;
}
