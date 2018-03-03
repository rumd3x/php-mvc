<?php

/**
 * Classe de Modelo de Regra de Negócio Padrão
 */
class DefaultModel extends Model
{
    public function __construct()
    {
        Loader::model('DefaultDAO');
        $this->dao = new DefaultDAO();
    }
    
    public function teste()
    {
        return $this->dao->select();
    }

}