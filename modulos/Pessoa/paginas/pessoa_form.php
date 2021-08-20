<!-- Button trigger modal -->

<!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">+</button> -->
<a class="btn btn-success" href="<?= $this->modulo ?>/list">+</a>
<br>

<!--
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
-->
<!-- form -->
<form class="modal-content was-validated" method="POST" action="<?= $this->modulo ?>/<?= $this->acao ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= "$this->acao_descricao $this->descricao_singular" ?> </h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
    </div>
    <div class="modal-body">

        <!-- id -->
        <input name="PessoaId" value="<?= $this->Dado['PessoaId'] ?>" hidden>

        <div class="row g-3">

            <!-- PrimeiroNome -->
            <div class="col-sm-6">
                <label for="PrimeiroNome" class="form-label">Primeiro nome:</label>
                <input type="text" class="form-control" id="PrimeiroNome" name="PrimeiroNome" required minlength="3" maxlength="255" value="<?= $this->Dado['PrimeiroNome'] ?>">
            </div>

            <!-- SegundoNome -->
            <div class="col-sm-6">
                <label for="SegundoNome" class="form-label">Segundo Nome:</label>
                <input type="text" class="form-control" id="SegundoNome" name="SegundoNome" required minlength="3" maxlength="255" value="<?= $this->Dado['PrimeiroNome'] ?>">
            </div>

        </div>

        <div class="row g-3">

            <!-- Endereco -->
            <div class="col-sm-6">
                <label for="Endereco" class="form-label">Endereço:</label>
                <input type="text" class="form-control" id="Endereco" name="Endereco" required minlength="3" maxlength="255" value="<?= $this->Dado['Endereco'] ?>">
            </div>

            <!-- CidadeId -->
            <div class="col-sm-6">
                <label for="CidadeId" class="form-label">Cidade:</label>
                <select class="form-select" name="CidadeId" id="CidadeId" required>
                    <option></option>
                    <?php foreach ($this->CidadeDados as $dado) : ?>
                        <option value="<?= $dado['CidadeId'] ?>" <?= $this->Dado['CidadeId'] == $dado['CidadeId'] ? 'selected' : '' ?>>
                            <?= $dado['CidadeDesc'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

        </div>

        <div class="row g-3">

            <!-- PrimeiroNome -->
            <div class="col-sm-6">
                <label for="DataNascimento" class="form-label">Data de nascimento:</label>
                <input type="date" class="form-control" id="DataNascimento" name="DataNascimento" required value="<?= $this->Dado['DataNascimento'] ?>">
            </div>

            <!-- CidadeId -->
            <div class="col-sm-6">
                <label for="Status" class="form-label">Status:</label>
                <select class="form-select" name="Status" id="Status" required>
                    <option></option>
                    <option value="1" <?= $this->Dado['Status'] == 1 ? 'selected' : '' ?>>
                        Ativo
                    </option>
                    <option value="2" <?= $this->Dado['Status'] == 2 ? 'selected' : '' ?>>
                        Inativo
                    </option>
                </select>
            </div>

        </div>

    </div>

    <!-- btn -->
    <div class="modal-footer">
        <!-- button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button> -->
        <button class="btn btn-success"><?= $this->acao_descricao ?></button>
    </div>

</form>

<!--
    </div>
</div>
-->