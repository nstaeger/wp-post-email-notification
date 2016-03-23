<?php

use Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressDatabaseBroker;
use Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressOptionsBroker;
use Nstaeger\CmsPluginFramework\Configuration;
use Nstaeger\WpPostEmailNotification\Model\JobModel;
use Nstaeger\WpPostEmailNotification\Model\Option;
use Nstaeger\WpPostEmailNotification\Model\SubscriberModel;

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

require __DIR__ . '/vendor/autoload.php';
$config = require  __DIR__ . '/config.php';

$configuration = new Configuration($config);

$option = new Option(new WordpressOptionsBroker($configuration));
$option->deleteAll();

$databaseBroker = new WordpressDatabaseBroker();

$jobModel = new JobModel($databaseBroker);
$jobModel->dropTable();

$subscriberModel = new SubscriberModel($databaseBroker);
$subscriberModel->dropTable();
