<form method="POST" action="<?= $this->modulo ?>/<?= $this->acao ?>">

    <!-- id -->
    <input name="PessoaId" value="<?= $this->Dado['PessoaId'] ?>" hidden>

    <!-- PrimeiroNome -->
    <label for="PrimeiroNome">Primeiro Nome:</label><br>
    <input name="PrimeiroNome" id="PrimeiroNome" type="text" maxlength="255" value="<?= $this->Dado['PrimeiroNome'] ?>" required>
    <br><br>

    <!-- SegundoNome -->
    <label for="SegundoNome">Segundo Nome:</label><br>
    <input name="SegundoNome" id="SegundoNome" type="text" maxlength="255" value="<?= $this->Dado['SegundoNome'] ?>" required>
    <br><br>

    <!-- Endereco -->
    <label for="Endereco">Endereço:</label><br>
    <input name="Endereco" id="Endereco" type="text" maxlength="50" value="<?= $this->Dado['Endereco'] ?>" required>
    <br><br>

    <!-- CidadeId -->
    <label for="CidadeId">Cidade:</label><br>
    <select name="CidadeId" id="CidadeId" required>
        <option></option>
        <?php foreach ($this->CidadeDados as $dado) : ?>
            <option value="<?= $dado['CidadeId'] ?>" <?= $this->Dado['CidadeId'] == $dado['CidadeId'] ? 'selected' : '' ?>>
                <?= $dado['CidadeDesc'] ?>
            </option>
        <?php endforeach ?>
    </select>
    <br><br>

    <!-- DataNascimento -->
    <label for="DataNascimento">Data de nascimento:</label><br>
    <input name="DataNascimento" id="DataNascimento" type="date" value="<?= $this->Dado['DataNascimento'] ?>" required>
    <br><br>

    <!-- Status -->
    <label for="Status">Status:</label><br>
    <select name="Status" id="Status" required>
        <option></option>
        <option value="1" <?= $this->Dado['Status'] == 1 ? 'selected' : '' ?>>
            Ativo
        </option>
        <option value="2" <?= $this->Dado['Status'] == 2 ? 'selected' : '' ?>>
            Inativo
        </option>
        </option>
    </select>
    <br><br>

    <!-- insert -->
    <button><?= $this->acao_descricao ?></button>
</form>