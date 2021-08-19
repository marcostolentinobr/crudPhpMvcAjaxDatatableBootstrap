<!-- bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jquery -->
<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>

<!-- datatable -->
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css'>
<script src='https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js'></script>

<!-- table -->
<table id='<?= $this->modulo ?>Datatable' class='display cell-border'>
    <thead>
        <?= $this->datatableTh ?>
    </thead>
    <tfoot>
        <?= $this->datatableTh ?>
    </tfoot>
</table>
<!-- fim table -->

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
            },
            error: function (xhr, error, code)
            {
             /*   console.log(xhr);
                console.log(code);
                */
               alert('sdfs');
            }
        });
        //fim datatable

    });
</script>