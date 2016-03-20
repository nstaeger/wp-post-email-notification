<?php

namespace Nstaeger\WpPostSubscription;

use Nstaeger\Framework\Plugin as BasePlugin;

class Plugin extends BasePlugin
{
    public function activate()
    {
//        $subscriberModel = new SubscriberModel();
//        $subscriberModel->createTable();
    }

    public function renderWidget(array $data)
    {
//        $this->view->render("widget/widget", $data);
    }

    public function renderWidgetForm(array $data)
    {
//        $this->view->render("widget/form", $data);
    }

    public function uninstall()
    {
//        $subscriberModel = new SubscriberModel($this->database);
//        $subscriberModel->dropTable();
    }
}
