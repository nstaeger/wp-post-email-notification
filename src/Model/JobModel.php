<?php

namespace Nstaeger\WpPostSubscription\Model;

use Nstaeger\Framework\Broker\DatabaseBroker;
use Nstaeger\Framework\Support\Time;

class JobModel
{
    const TABLE_NAME = '@@ps_jobs';

    /**
     * @var DatabaseBroker
     */
    private $database;

    public function __construct(DatabaseBroker $database)
    {
        $this->database = $database;
    }

    public function createNewJob($post_id)
    {
        if ($post_id == null || !is_int($post_id) || $post_id < 1) {
            throw new \RuntimeException('postId must be an integer value greater than 0');
        }

        $data = [
            'offset'     => 0,
            'post_id'    => $post_id,
            'next_round' => Time::now()->plusMinutes(5)->asSqlTimestamp()
        ];

        if ($this->database->insert(self::TABLE_NAME, $data) === false) {
            throw new \RuntimeException('Unable to add job to the database');
        }
    }

    public function createTable()
    {
        $query = "CREATE TABLE IF NOT EXISTS " . self::TABLE_NAME . " (
            id int(10) NOT NULL AUTO_INCREMENT,
            post_id int(10) NOT NULL,
            offset int(10) NOT NULL,
            next_round DATETIME NOT NULL,
            PRIMARY KEY  id (id)
        ) DEFAULT CHARSET=utf8;";

        if ($this->database->executeQuery($query) === false) {
            throw new \RuntimeException('Unable to create database for WP Post Subscription Plugin');
        }
    }

    public function dropTable()
    {
        $query = "DROP TABLE IF EXISTS " . self::TABLE_NAME;

        if ($this->database->executeQuery($query) === false) {
            throw new \RuntimeException('Unable to delete database for WP Post Subscription Plugin');
        }
    }
}
