<?php

namespace Nstaeger\WpPostEmailNotification\Model;

use Nstaeger\CmsPluginFramework\Broker\DatabaseBroker;
use Nstaeger\CmsPluginFramework\Support\ArgCheck;
use Nstaeger\CmsPluginFramework\Support\Time;

class JobModel
{
    const TABLE_NAME = '@@wppen_jobs';

    /**
     * @var DatabaseBroker
     */
    private $database;

    /**
     * @var Option
     */
    private $options;

    public function __construct(DatabaseBroker $database, Option $options)
    {
        $this->database = $database;
        $this->options = $options;
    }

    public function completeJob($id)
    {
        $this->delete($id);
    }

    public function createNewJob($post_id)
    {
        ArgCheck::isInt($post_id);

        if ($post_id < 1) {
            throw new \InvalidArgumentException('postId must be an integer value greater than 0');
        }

        $data = [
            'offset'         => 0,
            'post_id'        => $post_id,
            'next_round_gmt' => Time::now()->addSeconds($this->options->getJobInitialTimeWait())->asSqlTimestamp(),
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
            created_gmt DATETIME NOT NULL,
            PRIMARY KEY  id (id)
        ) DEFAULT CHARSET=utf8;";

        if ($this->database->executeQuery($query) === false) {
            throw new \RuntimeException('Unable to create database for WP Post Subscription Plugin');
        }
    }

    public function delete($id)
    {
        ArgCheck::isInt($id);

        $where = [
            'id' => $id
        ];

        if ($this->database->delete(self::TABLE_NAME, $where) === false) {
            throw new \RuntimeException('Unable to delete job from database (Post Subscription Plugin)');
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
        $query = sprintf("SELECT * FROM %s ORDER BY id", self::TABLE_NAME);

        return $this->database->fetchAll($query);
    }

    public function getNextJob()
    {
        $query = sprintf(
            "SELECT * FROM %s WHERE next_round_gmt <= '%s' ORDER BY id LIMIT 1",
            self::TABLE_NAME,
            Time::now()->asSqlTimestamp()
        );

        return $this->database->fetchAll($query);
    }

    public function removeJobsFor($postId)
    {
        ArgCheck::isInt($postId);

        $where = [
            'post_id' => $postId
        ];

        if ($this->database->delete(self::TABLE_NAME, $where) === false) {
            throw new \RuntimeException('Unable to delete job from database (Post Subscription Plugin)');
        }
    }

    public function rescheduleWithNewOffset($id, $addToOffset)
    {
        ArgCheck::isInt($id);
        ArgCheck::isInt($addToOffset);

        $query = sprintf(
            "UPDATE %s SET offset = offset + %u, next_round_gmt = '%s' WHERE id = %u",
            self::TABLE_NAME,
            $addToOffset,
            Time::now()->addSeconds($this->options->getJobBatchTimeWait())->asSqlTimestamp(),
            $id
        );

        return $this->database->executeQuery($query);
    }
}
