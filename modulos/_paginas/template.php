<!-- title -->
<h1>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_form_incluir_<?= $this->modulo ?>">
        +
    </button>
    <?= $this->descricao ?>
</h1>

<!-- title -->
<?= $this->msg ?>

<!-- table -->
<table id="<?= $this->modulo ?>Datatable" class="display" class="display" style="width:100%">
    <thead>
        <?= $this->datatableTh ?>
    </thead>
    <tfoot>
        <?= $this->datatableTh ?>
    </tfoot>
</table>
<!-- fim table -->

<script>
    var datatable = null;
    var modal_form_incluir = document.getElementById('modal_form_incluir_<?= $this->modulo ?>');
    $(document).ready(function() {

        //datatable
        datatable = $('#<?= $this->modulo ?>Datatable').DataTable({
            order: [
                [<?= $this->datatableSortDefalt ?>, 'asc']
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
            responsive: true,
            serverMethod: 'post',
            ajax: {
                url: 'api/<?= $this->modulo ?>/datatable'
            }
        });
        //fim datatable

    });

    //excluir
    function excluir(chave) {
        $.ajax({
            type: 'DELETE',
            url: 'api/<?= $this->modulo ?>/excluir/' + chave,
            success: function(data) {
                var data = $.parseJSON(data);

                //modal
                var modal = new bootstrap.Modal(document.getElementById('modal_msg'));
                $('#modal_msg .modal-title').html(data.title);
                $('#modal_msg .modal-body').html(
                    data.msg + '<br>' +
                    '<small style="font-size: 10px">' + data.detail + '</small>'
                );

                //reload datatable
                if (data.status == 1) {
                    datatable.ajax.reload();
                }

                //modal
                modal.show();
            }
        });
    }
    //fim excluir

    //editar
    function editar(chave) {
        $.ajax({
            type: 'PUT',
            url: 'api/<?= $this->modulo ?>/editar/' + chave,
            success: function(data) {
                var data = $.parseJSON(data);
                if (data.status == 1) {

                    //dados
                    $.each(data.detail, function(id, valor) {
                        $('#' + id).val(valor);
                    });

                    //modal
                    $('.modal-title', modal_form_incluir).html(data.title);
                    $(modal_form_incluir).attr('action', '<?= $this->modulo ?>/update');
                    $('.btn-success', modal_form_incluir).html('Alterar');
                    var modal = new bootstrap.Modal(modal_form_incluir);
                    modal.show();

                } else {

                    //modal
                    var modal = new bootstrap.Modal(document.getElementById('modal_msg'));
                    $('#modal_msg .modal-title').html(data.title);
                    $('#modal_msg .modal-body').html(
                        data.msg + '<br>' +
                        '<small style="font-size: 10px">' + data.detail + '</small>'
                    );
                    modal.show();
                }

            }
        });
    }
    //fim editar

    //btn reset incluir
    modal_form_incluir.addEventListener('hide.bs.modal', function() {
        $('.modal-title', modal_form_incluir).html('Incluir <?= $this->descricao_singular ?>');
        $(modal_form_incluir).attr('action', '<?= $this->modulo ?>/insert');
        $(modal_form_incluir).trigger('reset');
        $('.btn-success', modal_form_incluir).html('Incluir');
    })
</script>