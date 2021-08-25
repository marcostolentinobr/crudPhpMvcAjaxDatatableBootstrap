<?php require_once __DIR__ . '/config.php' ?>
<!doctype html>
<html lang="pt-br">


<header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- base_url -->
    <base href="<?= URL ?>" />

    <!-- title -->
    <title><?= TITULO ?></title>
</header>

<body class="container">

    <!-- menu -->
    <strong><?= TITULO ?></strong> |

    <?php
    foreach (MENU as $url => $desc) {
        echo "<a href='$url'>$desc</a> | ";
    }
    ?>
    <hr style="margin: 5px 0px">

    <!-- conteudo -->
    <?php require_once RAIZ . '/modulos/View.php' ?>
</body>

</html>