<?php

echo "
    <h1>$this->descricao</h1>
    $this->msg
";

$this->addPagina('form');

echo '<br>';

$this->addPagina('list');