# Solução para acompanhar suas entregas.

## Problema

Criar um cadastro de projetos com a data de início e data final para a entrega, esse projeto deve pode ter 1 ou N atividades que também precisam ser cadastradas com as datas de início e data de fim. Após ter feito todos os cadastros precisamos saber quantos % dos projetos já temos finalizados e também se o projeto terá atrasos ou não. Para saber a % de andamento do projeto deve ser considerado o número de atividades finalizadas e quantidade de atividades ainda sem finalizar. Para saber se o projeto terá atraso considere a maior data final das atividades e compare com a data final do projeto, se for maior que a data final, o projeto terminará com atrasos. Abaixo segue tabelas para cadastros.

#### Tabela Projetos
| Campo           | Tipo    | Obrigatório  |
| :-------------- | :-----: | -----------: |
| Nome do Projeto | Texto   | Sim          |
| Data Início     | Data    | Sim          |
| Data de fim     | Data    | Sim          |
| *Data concluído | Data    | Não          |

#### Tabela Atividades
| Campo             | Tipo    | Obrigatório  |
| :--------------   | :-----: | -----------: |
| ID do Projeto     | Inteiro | Sim          |
| Nome da Atividade | Texto   | Sim          |
| Data Início       | Data    | Sim          |
| Data de fim       | Data    | Sim          |
| *Data concluída   | data    | Não          |

## Simulações

#### Simulação 1

| ID Projeto | Nome Projeto | Data Inicio | Data Fim   | % Completo | Atrasado |
| :--------- | :----------: | ----------: | ---------: | ---------: | -------: |
| 1          | Projeto 1    | 01/01/2019  | 31/01/2019 | 50%        | Não      |

| ID Atividade | ID Projeto | Nome Atividade | Data Inicio | Data Fim   | Finalizada? |
| :---------- | :---------: | -------------: | ----------: | ---------: | ----------: |
| 1          | 1            | Atividade 1    | 06/01/2019  | 15/01/2019 | Sim         |
| 2          | 1            | Atividade 2    | 16/01/2019  | 31/01/2019 | Não         |

#### Simulação 2

| ID Projeto | Nome Projeto | Data Inicio | Data Fim   | % Completo | Atrasado |
| :--------- | :----------: | ----------: | ---------: | ---------: | -------: |
| 2          | Projeto 2    | 01/02/2019  | 28/02/2019 | 0%         | Sim      |

| ID Atividade | ID Projeto | Nome Atividade | Data Inicio | Data Fim   | Finalizada? |
| :---------- | :---------: | -------------: | ----------: | ---------: | ----------: |
| 1          | 2            | Atividade 1    | 01/02/2019  | 10/02/2019 | Não         |
| 2          | 2            | Atividade 2    | 11/02/2019  | 20/02/2019 | Não         |
| 3          | 2            | Atividade 3    | 21/02/2019  | 02/03/2019 | Não         |

## Falta
* Artefatos/Tarefas.txt

## Rodar
* Criar banco no mysql;
* Rodar Artefatos/script.sql 