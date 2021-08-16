# sensedia

## Problema

* CRUD para usuários; 
* PHP e Mysql; 

#### Pessoa - Tabela

| Campo          | Tipo         | Outros   |
| :------------- | :----------: | -------: |
| PessoaId       | bigint       | PK, AUTO |
| PrimeiroNome   | varchar(255) | NOT NULL |
| SegundoNome    | varchar(255) | NOT NULL |
| Endereco       | varchar(255) | NOT NULL |
| CidadeId       | smallint     | NOT NULL |
| DataNascimento | date         | NOT NULL |
| DataCadastro   | datetime     | NOT NULL |
| Status         | CHAR(1)      | NOT NULL |

* obs.: Status: 1 para ativo e 2 para inativo; 

#### Cidade - Tabela

| Campo      | Tipo         | Outros   |
| :--------- | :----------: | -------: |
| CidadeId   | smallint     | PK, AUTO |
| CidadeDesc | varchar(255) | NOT NULL |

* Script para povoar com as cidades:

. São Paulo; 
. Rio de Janeiro; 
. Salvador; 
. Pernambuco; 
. Lapa; 
. São Carlos; 
. Rondonópolis; 
. Bragança Paulista; 

### Usuário - Tela 

* Novo usuário+ (Ícone bonequinho) 
* Buscar
* ID | Nome             | Nascimento | Endereço      | Cidade   | Status        | Edit, Delete
* 1  | Marcos Tolentino | 22/03/1991 | Rua Koesa 415 | Imbituba | Ativo (Verde) | Edit, Delete
* Obs.: Inativo (Vermelho)
* Obs.: Mais informações Artefatos/sensedia.docx  

### Usuário - cadastro/edição

* Primeiro Nome      | Segundo Nome
* Endereço           | Cidade
* Data de Nascimento | Status (Ativo/Inativo)
* Salvar, Cancelar 
Obs.: Exemplo de cadastro e edição em Artefatos/sensedia.docx

### Conclusão

* Analise de Back end;
* Flexibilidade de formato e estrutura;
* Subir para repositório com o banco e scrips
* Lembrar do script de cidades;

### Como Rodar

1ª Foi usado "PDO" no PHP 8 e Mysql 8. Garantir que o PDO esteja 
   habilitado/instalado. Verifique o php.ini; 

2ª Crar um banco e executar o script.sql localizado na pasta Artefatos
   obs.: Comentado a execução do banco chaamado SENSEDIA, caso queira usar; 

3ª Configurar o arquivo config.php com os dados do banco;

4ª Rodar