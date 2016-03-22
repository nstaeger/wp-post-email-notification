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
            'offset'         => 0,
            'post_id'        => $post_id,
            'next_round_gmt' => Time::now()->plusMinutes(5)->asSqlTimestamp(),
            'created_gmt'    => Time::now()->asSqlTimestamp()
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
            next_round_gmt DATETIME NOT NULL,
            created_gmt DATETIME NOT NULL DEFAULT NOW(),
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

        if ($this->database->delete(self::TABLE_NAME, $where) === false) {
            throw new \RuntimeException('Unable to delete subscriber from database (Post Subscription Plugin)');
        }
    }

    public function dropTable()
    {
        $query = sprintf("DROP TABLE IF EXISTS %s", self::TABLE_NAME);

        if ($this->database->executeQuery($query) === false) {
            throw new \RuntimeException('Unable to delete database for WP Post Subscription Plugin');
        }
    }

    public function getAll()
    {
        $query = sprintf("SELECT * FROM %s", self::TABLE_NAME);

        return $this->database->fetchAll($query);
    }

    public function getNextJob()
    {
        $query = sprintf(
            "SELECT * FROM %s WHERE next_round_gmt <= '%s' LIMIT 1",
            self::TABLE_NAME,
            Time::now()->asSqlTimestamp()
        );

        return $this->database->fetchAll($query);
    }

    public function rescheduleWithNewOffset($id, $addToOffset)
    {
        $query = sprintf("UPDATE %s SET offset = offset + %d, next_round_gmt = %s WHERE id = %u", self::TABLE_NAME, $addToOffset, Time::now()->addSeconds(2), $id);

        return $this->database->executeQuery($query);
    }

    public function completeJob($id)
    {
        $this->delete($id);
    }
}
