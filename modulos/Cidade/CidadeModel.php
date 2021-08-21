<?php

class CidadeModel extends Model
{

    protected $select = '
        SELECT C.CidadeId,
               C.CidadeDesc
          FROM Cidade C
      ORDER BY C.CidadeDesc
    ';
}
