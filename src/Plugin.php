<?php

namespace Nstaeger\WpPostSubscription;

use Nstaeger\Framework\Asset\AssetItem;
use Nstaeger\Framework\Configuration;
use Nstaeger\Framework\Creator\Creator;
use Nstaeger\Framework\Plugin as BasePlugin;
use Nstaeger\WpPostSubscription\Model\JobModel;
use Nstaeger\WpPostSubscription\Model\SubscriberModel;
use Nstaeger\WpPostSubscription\Widget\SubscriptionWidget;

class Plugin extends BasePlugin
{
    function __construct(Configuration $configuration, Creator $creator)
    {
        parent::__construct($configuration, $creator);

        $this->menu()->registerAdminMenuItem('WP Post Subscription')
             ->withAction('AdminPageController@optionsPage')
             ->withAsset('js/bundle/admin-options.js');

        // TODO access control!
        $this->ajax()->registerEndpoint('subscriber', 'GET', 'AdminSubscriberController@get');
        $this->ajax()->registerEndpoint('subscriber', 'POST', 'AdminSubscriberController@post');
        $this->ajax()->registerEndpoint('subscriber', 'DELETE', 'AdminSubscriberController@delete');
        $this->ajax()->registerEndpoint('subscribe', 'POST', 'FrontendSubscriberController@post', true);

        $this->registerWidget(SubscriptionWidget::class);
    }

    public function activate()
    {
        $this->subscriber()->createTable();
    }

    public function deactivate()
    {
        $this->subscriber()->dropTable();
    }

    public function registerWidget($class)
    {
        $this->asset()->addAsset(new AssetItem('js/bundle/frontend-widget.js'));

        add_action(
            'widgets_init',
            function () use ($class) {
                register_widget($class);
            }
        );
    }

    /**
     * @return JobModel
     */
    public function jobs()
    {
        return $this->make(JobModel::class);
    }

    /**
     * @return SubscriberModel
     */
    public function subscriber()
    {
        return $this->make(SubscriberModel::class);
    }
}
