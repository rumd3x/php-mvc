<?php

/**
 * Classe de Acesso ao Banco para a model Default
 */
class DefaultDAO extends DAO
{
    public function select() {
        return $this->db->get('migrations')->result();
    }
}