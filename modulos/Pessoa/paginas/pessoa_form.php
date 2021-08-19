<form class="was-validated" method="POST" action="<?= $this->modulo ?>/<?= $this->acao ?>">

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

    <!-- btn -->
    <hr class="my-4">
    <button class="btn btn-primary"><?= $this->acao_descricao ?></button>

</form>