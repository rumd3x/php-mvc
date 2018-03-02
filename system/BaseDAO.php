<?php

/**
 * Classe base de DAO
 */

abstract class DAO
{
    protected $db;
    
    public function __construct()
    {
        $this->db = ActiveRecord::getInstance();
    }
}