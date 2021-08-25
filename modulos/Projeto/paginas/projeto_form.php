<form class="modal fade" data-bs-backdrop="static" id="modal_form_<?= $this->modulo ?>" method="POST" onsubmit="incluir(this)">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <!-- title -->
                <h5 class="modal-title"><?= "Incluir $this->descricao_singular" ?> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- id -->
                <input id="id" name="id" value="<?= $this->Dado['id'] ?>" hidden>

                <div class="row g-3">

                    <!-- nome -->
                    <div class="col-sm-12">
                        <label for="nome" class="form-label">Projeto:</label>
                        <input type="text" class="form-control" id="nome" name="nome" required minlength="3" maxlength="255" value="<?= $this->Dado['nome'] ?>">
                    </div>

                </div>

                <div class="row g-3">

                    <!-- data_fim -->
                    <div class="col-sm-12">
                        <label for="data_fim" class="form-label">Fim:</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" required value="<?= $this->Dado['data_fim'] ?>">
                    </div>

                </div>

            </div>

            <!-- btn -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button class="btn btn-success">Incluir</button>
            </div>

        </div>
    </div>
</form>