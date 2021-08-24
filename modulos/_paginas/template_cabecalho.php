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