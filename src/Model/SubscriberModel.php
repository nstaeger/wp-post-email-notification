<?php

namespace Nstaeger\WpPostEmailNotification\Model;

use Nstaeger\CmsPluginFramework\Broker\DatabaseBroker;
use Nstaeger\CmsPluginFramework\Support\ArgCheck;
use Symfony\Component\HttpFoundation\Request;

class SubscriberModel
{
    const TABLE_NAME = '@@wppen_subscribers';

    /**
     * @var DatabaseBroker
     */
    private $database;

    public function __construct(DatabaseBroker $database)
    {
        $this->database = $database;
    }

    /**
     * @param Request $request
     */
    public function add(Request $request)
    {
        $subscriber = json_decode($request->getContent());

        $email = isset($subscriber->email) ? sanitize_email($subscriber->email) : null;
        $ip = $request->getClientIp();

        $this->addPlain($email, $ip);
    }

    public function createTable()
    {
        $query = "CREATE TABLE IF NOT EXISTS " . self::TABLE_NAME . " (
            id int(10) NOT NULL AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL,
            ip VARCHAR(255),
            created DATETIME NOT NULL DEFAULT NOW(),
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

    public function getEmails($offset, $count)
    {
        ArgCheck::isInt($offset);
        ArgCheck::isInt($count);

        $query = sprintf("SELECT email FROM %s LIMIT %d, %d", self::TABLE_NAME, $offset, $count);

        return $this->database->fetchAll($query);
    }

    private function addPlain($email, $ip)
    {
        ArgCheck::isEmail($email);
        ArgCheck::isIp($ip);

        $data = [
            'email' => $email,
            'ip'    => $ip
        ];

        if ($this->database->insert(self::TABLE_NAME, $data) === false) {
            throw new \RuntimeException('Unable to add subscriber to the database');
        }
    }
}
