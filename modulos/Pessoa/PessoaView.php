




<h1>
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_form_incluir_<?= $this->modulo ?>">+</button>    

<?= $this->descricao ?>
</h1>

<?= $this->msg ?>

<!-- table -->
<table id='<?= $this->modulo ?>Datatable'>
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
    $(document).ready(function() {

        //datatable
        datatable = $('#<?= $this->modulo ?>Datatable').DataTable({
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
            type: 'GET',
            url: 'api/<?= $this->modulo ?>/editar/' + chave,
            success: function(data) {
                var data = $.parseJSON(data);
                if (data.status == 1) {

                    //dados
                    $.each(data.detail, function(id, valor) {
                        $('#' + id).val(valor);
                    });

                    //modal
                    $('#modal_form_incluir_<?= $this->modulo ?> .modal-title').html(data.title);
                    $('#modal_form_incluir_<?= $this->modulo ?>').attr('action', '<?= $this->modulo ?>/update');
                    $('#modal_form_incluir_<?= $this->modulo ?>').attr('method', 'PUT');
                    $('#modal_form_incluir_<?= $this->modulo ?> .btn-success').html('Alterar');
                    var modal = new bootstrap.Modal(document.getElementById('modal_form_incluir_<?= $this->modulo ?>'));
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
    var modal = document.getElementById('modal_form_incluir_<?= $this->modulo ?>');
    modal.addEventListener('hide.bs.modal', function() {
        $('#modal_acao .modal-title').html('Incluir <?= $this->descricao_singular ?>');
        var form = $('#form_<?= $this->modulo ?>');
        form.attr('action', '<?= $this->modulo ?>/insert');
        form.attr('method', 'POST');
        form.trigger('reset');
        $('#form_<?= $this->modulo ?> .btn-success').html('Incluir');
    })
</script>