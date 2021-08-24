<script>
    //parametros
    var form = document.getElementById('modal_form_<?= $this->modulo ?>');
    var modal_form = new bootstrap.Modal(form);
    var modal_msg = new bootstrap.Modal(document.getElementById('modal_msg'));

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