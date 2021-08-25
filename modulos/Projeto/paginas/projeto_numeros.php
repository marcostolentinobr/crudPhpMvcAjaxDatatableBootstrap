<small id="projeto_quantidade"></small> |
<small id="projeto_porcentagem"></small>
<br>
<br>

<script>
    function numeros() {
        $.ajax({
            url: 'api/<?= $this->modulo ?>/numeros',
            success: function(data) {
                var data = $.parseJSON(data);
                console.log(data.detail.qtd);
                $('#projeto_quantidade').html('<b>Quantidade: </b>' + data.detail.qtd);
                $('#projeto_porcentagem').html('<b>Concluído(%): </b>' + data.detail.concluido_por);
            }
        });
    }
    numeros();

    //ao fechar excluir
    var modal_msg = document.getElementById('modal_msg');
    modal_msg.addEventListener('hide.bs.modal', function() {
        numeros();
    })
</script>