<?php

namespace Nstaeger\WpPostSubscription\Model;

use Nstaeger\Framework\Broker\DatabaseBroker;

class SubscriberModel
{
    /**
     * @var DatabaseBroker
     */
    private $database;

    public function __construct(DatabaseBroker $database)
    {
        $this->database = $database;
    }

    public function add($email, $ip)
    {
        $data = [
            'email'   => $email,
            'ip'      => $ip,
            'created' => current_time('mysql')
        ];

        if ($this->database->insert("@@ps_subscribers", $data) === false) {
            throw new \RuntimeException('Unable to add subscriber to the database (Post Subscription Plugin)');
        }
    }

    public function createTable()
    {
        $query = "CREATE TABLE IF NOT EXISTS @@ps_subscribers (
            id int(10) NOT NULL AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL,
            ip VARCHAR(255),
            created DATETIME NOT NULL,
            PRIMARY KEY  id (id)
        ) DEFAULT CHARSET=utf8;";

        if ($this->database->executeQuery($query) === false) {
            throw new \RuntimeException('Unable to create database for WP Post Subscription Plugin');
        }
    }

    public function delete($id)
    {
        $where = [
            'id' => $id
        ];

        if ($this->database->delete("@@ps_subscribers", $where) === false) {
            throw new \RuntimeException('Unable to delete subscriber from database (Post Subscription Plugin)');
        }
    }

    public function dropTable()
    {
        $query = "DROP TABLE IF EXISTS @@ps_subscribers";

        if ($this->database->executeQuery($query) === false) {
            throw new \RuntimeException('Unable to delete database for WP Post Subscription Plugin');
        }
    }

    public function getAll()
    {
        $query = "SELECT * FROM @@ps_subscribers";

        return $this->database->fetchAll($query);
    }
}
