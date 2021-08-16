<table border="1">
    <thead>

        <!-- cabeçalho -->
        <th>Id</th>
        <th>Nome</th>
        <th>Nascimento</th>
        <th>Endereço</th>
        <th>Cidade</th>
        <th>Status</th>
        <th>Ações</th>

    </thead>
    <tbody>

        <!-- Sem dados -->
        <?php if (count($this->Dados) == 0) : ?>
            <tr>
                <td colspan="100%">Sem dados para listar</td>
            </tr>
        <?php else : ?>

            <!-- loop de dados -->
            <?php foreach ($this->Dados as $dado) : ?>
                <tr>

                    <!-- dados -->
                    <td><?= $dado['PessoaId'] ?></td>
                    <td><?= "$dado[PrimeiroNome] $dado[SegundoNome]" ?></td>
                    <td><?= $dado['DataNascimento'] ?></td>
                    <td><?= $dado['Endereco'] ?></td>
                    <td><?= $dado['CidadeDesc'] ?></td>
                    <td><?= $dado['StatusDesc'] ?></td>

                    <!-- ações -->
                    <td>
                        <a href="<?= $this->modulo ?>/edit/<?= $dado['PessoaId'] ?>">Editar</a>
                        <a href="<?= $this->modulo ?>/delete/<?= $dado['PessoaId'] ?>">Excluir</a>
                    </td>

                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>