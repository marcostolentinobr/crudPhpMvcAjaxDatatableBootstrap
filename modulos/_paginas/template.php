<!-- title -->
<h1>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_form_<?= $this->modulo ?>">
        +
    </button>
    <?= $this->descricao ?>
</h1>

<!-- modal_msg -->
<div class="modal fade" id="modal_msg" data-bs-backdrop="static" style="z-index: 1056;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <!-- title -->
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- body -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim modal_msg -->

<!-- table -->
<table id="<?= $this->modulo ?>Datatable" class="display cell-border" style="width:100%">
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
    var form = document.getElementById('modal_form_<?= $this->modulo ?>');
    var modal_form = new bootstrap.Modal(form);
    var modal_msg = new bootstrap.Modal(document.getElementById('modal_msg'));
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

    //incluir
    function incluir(e) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            data: $(e).serialize(),
            url: 'api/<?= $this->modulo ?>/insert',
            success: function(data) {
                var data = $.parseJSON(data);

                //modal_msg
                $('#modal_msg .modal-title').html(data.title);
                $('#modal_msg .modal-body').html(
                    data.msg + '<br>' +
                    '<small style="font-size: 10px">' + data.detail + '</small>'
                );
                modal_msg.show();

                //reload datatable
                if (data.status == 1) {
                    datatable.ajax.reload();
                    modal_form.hide();
                }
            }
        });
    }
    //fim incluir

    //excluir
    function excluir(chave) {
        $.ajax({
            type: 'POST',
            url: 'api/<?= $this->modulo ?>/excluir/' + chave,
            success: function(data) {
                var data = $.parseJSON(data);

                //modal_msg
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
                modal_msg.show();
            }
        });
    }
    //fim excluir

    //editar
    function editar(chave) {
        $.ajax({
            type: 'POST',
            url: 'api/<?= $this->modulo ?>/editar/' + chave,
            success: function(data) {
                var data = $.parseJSON(data);

                //ok
                if (data.status == 1) {

                    //dados
                    $.each(data.detail, function(id, valor) {
                        $('#' + id).val(valor);
                    });

                    //modal_form
                    $('.modal-title', form).html(data.title);
                    $(form).attr('onsubmit', 'alterar(this)');
                    $('.btn-success', form).html('Alterar');
                    modal_form.show();

                }
                //erro
                else {

                    //modal_msg
                    $('#modal_msg .modal-title').html(data.title);
                    $('#modal_msg .modal-body').html(
                        data.msg + '<br>' +
                        '<small style="font-size: 10px">' + data.detail + '</small>'
                    );
                    modal_msg.show();
                }

            }
        });
    }
    //fim editar

    //alterar
    function alterar(e) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            data: $(e).serialize(),
            url: 'api/<?= $this->modulo ?>/update',
            success: function(data) {
                var data = $.parseJSON(data);

                //modal_msg
                $('#modal_msg .modal-title').html(data.title);
                $('#modal_msg .modal-body').html(
                    data.msg + '<br>' +
                    '<small style="font-size: 10px">' + data.detail + '</small>'
                );
                modal_msg.show();

                //reload datatable
                if (data.status == 1) {
                    datatable.ajax.reload();
                    modal_form.hide();
                }
            }
        });
    }
    //fim alterar

    //btn reset incluir
    form.addEventListener('hide.bs.modal', function() {
        $('.modal-title', form).html('Incluir <?= $this->descricao_singular ?>');
        $(form).attr('onsubmit', 'incluir(this)');
        $(form).trigger('reset');
        $('.btn-success', form).html('Incluir');
    })
</script>