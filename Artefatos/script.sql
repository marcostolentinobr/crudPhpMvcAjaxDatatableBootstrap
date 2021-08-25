-- CREATE DATABASE EUAX CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE PROJETO (
                id INT AUTO_INCREMENT NOT NULL,
                nome VARCHAR(50) NOT NULL,
                data_fim DATE NOT NULL,
                PRIMARY KEY (id)
);

CREATE TABLE ATIVIDADE (
                id BIGINT AUTO_INCREMENT NOT NULL,
                projeto_id INT NOT NULL,
                nome VARCHAR(50) NOT NULL,
                data_inicio DATE NOT NULL,
                data_fim DATE NOT NULL,
                data_concluido DATE,
                PRIMARY KEY (id)
);

ALTER TABLE ATIVIDADE ADD CONSTRAINT projeto_atividade_fk
FOREIGN KEY (projeto_id)
REFERENCES PROJETO (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;