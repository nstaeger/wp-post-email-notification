<?php

namespace Nstaeger\WpPostSubscription\Database;

use wpdb;

class Database
{
    private $db;

    public function __construct(wpdb $db)
    {
        $this->db = $db;
    }

    public function delete($table, $where)
    {
        return $this->db->delete($this->parsePrefix($table), $where);
    }

    public function executeQuery($query)
    {
        return $this->db->query($this->parsePrefix($query));
    }

    public function fetchAll($query)
    {
        return $this->db->get_results($this->parsePrefix($query), ARRAY_A);
    }

    public function insert($table, $data)
    {
        $this->db->insert($this->parsePrefix($table), $data);
    }

    private function parsePrefix($query)
    {
        return str_replace("@@", $this->db->prefix, $query);
    }
}
