-- CREATE DATABASE SENSEDIA CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE Cidade (
                CidadeId SMALLINT AUTO_INCREMENT NOT NULL,
                CidadeDesc VARCHAR(255) NOT NULL,
                PRIMARY KEY (CidadeId)
);


CREATE TABLE Pessoa (
                PessoaId BIGINT AUTO_INCREMENT NOT NULL,
                PrimeiroNome VARCHAR(255) NOT NULL,
                SegundoNome VARCHAR(255) NOT NULL,
                CidadeId SMALLINT NOT NULL,
                Endereco VARCHAR(255) NOT NULL,
                DataNascimento DATE NOT NULL,
                DataCadastro DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                Status CHAR(1) NOT NULL,
                PRIMARY KEY (PessoaId)
);


ALTER TABLE Pessoa ADD CONSTRAINT cidade_pessoa_fk
FOREIGN KEY (CidadeId)
REFERENCES Cidade (CidadeId)
ON DELETE NO ACTION
ON UPDATE NO ACTION;
