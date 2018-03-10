<?php

/**
 * Classe de Acesso ao Banco para a model Default
 */
class ExampleDAO extends DAO
{
    public function select() {
        return $this->db->get('table_name')->result();
    }
}