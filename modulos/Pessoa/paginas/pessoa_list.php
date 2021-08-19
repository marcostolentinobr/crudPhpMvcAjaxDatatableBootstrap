<!-- datatable -->
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css'>

<table id='<?= $this->modulo ?>Datatable' class='display cell-border'>
    <thead>
        <?= $this->datatableTh ?>
    </thead>
    <tfoot>
        <?= $this->datatableTh ?>
    </tfoot>
</table>

<!-- jquery -->
<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>

<!-- datatable -->
<script src='https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js'></script>

<script>
    $(document).ready(function() {

        //datatable
        $('#<?= $this->modulo ?>Datatable').DataTable({
            order: [
                [<?= $this->datatableSortDefalt ?>, 'desc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [<?= implode(',', $this->datatableNoSort) ?>]
            }],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
            },
            searchDelay: 350,
            processing: true,
            serverSide: true,
            serverMethod: 'post',
            ajax: {
                url: 'api/<?= $this->modulo ?>/datatable'
            }
        });
        //fim datatable

    });
</script>