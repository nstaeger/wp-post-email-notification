<?php

namespace Nstaeger\WpPostSubscription;

use Nstaeger\WpPostSubscription\Ajax\AjaxRequestHandler;
use Nstaeger\WpPostSubscription\Database\Database;
use Nstaeger\WpPostSubscription\Database\SubscriberModel;
use Nstaeger\WpPostSubscription\Http\Request;
use Nstaeger\WpPostSubscription\View\ViewRenderer;

class Plugin
{
    private $database;
    private $directory;
    private $view;

    public function __construct($dir, $db)
    {
        $this->database = new Database($db);
        $this->directory = $dir;
        $this->view = new ViewRenderer($this->directory);
    }

    public function activate()
    {
        $subscriberModel = new SubscriberModel($this->database);
        $subscriberModel->createTable();
    }

    public function handleAjaxRequest()
    {
        $handler = new AjaxRequestHandler($this->database);
        $request = Request::createFromGlobals();

        $response = $handler->handle($request);

        $response->send();
        die();
    }

    public function renderOptionsPage()
    {
        $this->view->render("options");
    }

    public function uninstall()
    {
        $subscriberModel = new SubscriberModel($this->database);
        $subscriberModel->dropTable();
    }
}
