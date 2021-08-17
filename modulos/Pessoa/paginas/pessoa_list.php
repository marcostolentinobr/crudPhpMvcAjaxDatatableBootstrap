<!-- datatable -->
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css'>

<?php

$thead_tfoot = '
    <th>Id</th>
    <th>Nome</th>
    <th>Nascimento</th>
    <th>Endereço</th>
    <th>Cidade</th>
    <th>Status</th>
    <th>Ações</th>
';

?>

<table id='PessoaList' class="stripe hover">
    <thead>
        <?= $thead_tfoot ?>
    </thead>
    <tfoot>
        <?= $thead_tfoot ?>
    </tfoot>
</table>

<!-- jquery -->
<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>

<!-- datatable -->
<script src='https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js'></script>

<script>
    $(document).ready(function() {

        //datatable
        $('#PessoaList').DataTable({
            "order": [
                [1, "desc"]
            ],
            columnDefs: [{
                orderable: false,
                targets: [6]
            }],
            'language': {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
            },
            'processing': true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
                url: 'api/Pessoa/datatable'
            }
        });
        //fim datatable

    });
</script>