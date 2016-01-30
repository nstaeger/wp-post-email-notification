<?php

namespace Nstaeger\Framework\Broker\Wordpress;

use Nstaeger\Framework\Broker\DatabaseBroker;
use wpdb;

class WordpressDatabaseBroker implements DatabaseBroker
{
    /**
     * @var wpdb
     */
    private $databaseConnection;

    public function __construct()
    {
        $this->databaseConnection = $GLOBALS['wpdb'];
    }

    public function delete($table, array $where)
    {
        return $this->databaseConnection->delete($this->parsePrefix($table), $where);
    }

    public function executeQuery($query)
    {
        return $this->databaseConnection->query($this->parsePrefix($query));
    }

    public function fetchAll($query)
    {
        return $this->databaseConnection->get_results($this->parsePrefix($query), ARRAY_A);
    }

    public function insert($table, array $data)
    {
        return $this->databaseConnection->insert($this->parsePrefix($table), $data);
    }

    private function parsePrefix($query)
    {
        return str_replace("@@", $this->databaseConnection->prefix, $query);
    }
}
