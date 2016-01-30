<?php

namespace Nstaeger\WpPostSubscription;

use Nstaeger\Framework\Plugin as BasePlugin;
use Nstaeger\WpPostSubscription\Ajax\AjaxRequestHandler;
use Nstaeger\WpPostSubscription\Ajax\FrontendAjaxRequestHandler;
use Nstaeger\WpPostSubscription\Database\Database;
use Nstaeger\WpPostSubscription\Database\SubscriberModel;
use Nstaeger\WpPostSubscription\Http\Request;
use Nstaeger\WpPostSubscription\View\ViewRenderer;

class Plugin extends BasePlugin
{
    private static $self;

    private $url;
    private $directory;
    private $database;
    private $view;

//    public function __construct($url, $dir, $db)
//    {
//        self::$self = $this;
//
//        $this->url = $url;
//        $this->directory = $dir;
//        $this->database = new Database($db);
//
//        $this->view = new ViewRenderer($this->directory);
//    }

    public static function self()
    {
        if (self::$self == null) {
            throw new \UnexpectedValueException("Trying to access Plugin::self(), but Plugin was not initialized.");
        }

        return self::$self;
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

    public function renderWidget(array $data)
    {
        $this->view->render("widget/widget", $data);
    }

    public function renderWidgetForm(array $data)
    {
        $this->view->render("widget/form", $data);
    }

    public function uninstall()
    {
        $subscriberModel = new SubscriberModel($this->database);
        $subscriberModel->dropTable();
    }

    public function getUrl()
    {
        return $this->url;
    }
}
