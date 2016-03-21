<?php

namespace Nstaeger\WpPostSubscription;

use Nstaeger\Framework\Asset\AssetItem;
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
        $this->asset()->addAsset(new AssetItem('js/bundle/frontend-widget.js'));

        add_action('widgets_init', function () use ($class) {
            register_widget($class);
        });
    }

    public function uninstall()
    {
//        $subscriberModel = new SubscriberModel($this->database);
//        $subscriberModel->dropTable();
    }
}
