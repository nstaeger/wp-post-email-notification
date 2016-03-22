<?php

namespace Nstaeger\WpPostSubscription\Model;

use Nstaeger\Framework\Broker\DatabaseBroker;
use Symfony\Component\HttpFoundation\Request;

class SubscriberModel
{
    const TABLE_NAME = '@@ps_subscribers';

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
     * @throws InvalidArgumentException
     */
    public function add(Request $request)
    {
        $subscriber = json_decode($request->getContent());

        $email = isset($subscriber->email) ? sanitize_email($subscriber->email) : null;
        $ip = isset($subscriber->ip) && !empty($subscriber->ip)
            ? $subscriber->ip
            : $request->getClientIp();

        if (empty($email) || !is_email($email)) {
            throw new InvalidArgumentException("Email not valid.");
        }

        if (!empty($ip) && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false
            && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false
        ) {
            throw new InvalidArgumentException("IP not valid.");
        }

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
        $query = sprintf("SELECT email FROM %s LIMIT %d, %d", self::TABLE_NAME, $offset, $count);

        return $this->database->fetchAll($query);
    }

    private function addPlain($email, $ip)
    {
        $data = [
            'email' => $email,
            'ip'    => $ip
        ];

        if ($this->database->insert(self::TABLE_NAME, $data) === false) {
            throw new \RuntimeException('Unable to add subscriber to the database');
        }
    }
}
