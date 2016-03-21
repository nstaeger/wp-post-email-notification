<?php

namespace Nstaeger\WpPostSubscription\Model;

use Nstaeger\Framework\Broker\DatabaseBroker;

class JobModel
{
    /**
     * @var DatabaseBroker
     */
    private $database;

    public function __construct(DatabaseBroker $database)
    {
        $this->database = $database;
    }

    public function createTable()
    {
        $query = "CREATE TABLE IF NOT EXISTS @@ps_jobs (
            id int(10) NOT NULL AUTO_INCREMENT,
            offset int(10) NOT NULL,
            post_id int(10),
            next_round DATETIME NOT NULL,
            PRIMARY KEY  id (id)
        ) DEFAULT CHARSET=utf8;";

        if ($this->database->executeQuery($query) === false) {
            throw new \RuntimeException('Unable to create database for WP Post Subscription Plugin');
        }
    }

    public function dropTable()
    {
        $query = "DROP TABLE IF EXISTS @@ps_jobs";

        if ($this->database->executeQuery($query) === false) {
            throw new \RuntimeException('Unable to delete database for WP Post Subscription Plugin');
        }
    }
}
