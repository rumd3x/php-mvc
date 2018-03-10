<?php

/**
 * Classe de Modelo de Regra de Negócio de Exemplo
 */
class ExampleModel extends Model
{
    public function __construct()
    {
        Loader::model('ExampleDAO');
        $this->dao = new ExampleDAO();
    }
    
    public function teste()
    {
        return $this->dao->select();
    }

}