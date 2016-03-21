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

    public function registerWidget($class)
    {
        add_action('widgets_init', function () use ($class) {
            $this->asset()->addAsset('js/bundle/frontend-widget.js');
            register_widget($class);
        });
    }

    public function uninstall()
    {
//        $subscriberModel = new SubscriberModel($this->database);
//        $subscriberModel->dropTable();
    }
}
