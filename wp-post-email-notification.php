<?php

/**
 * Plugin Name: WP Post Email Notification
 * Description: Send email notifications to subscribers when a new post was published
 * Version: 0.1.0
 * Author: Nicolai Stäger
 * Author URI: http://nstaeger.de
 */

/**
 * TODO add options to modify email-look
 * TODO better check email-sending
 * TODO check if deleting of jobs works as expected
 * TODO look over the sendEmail method again
 */

use Nstaeger\CmsPluginFramework\Asset\AssetItem;
use Nstaeger\CmsPluginFramework\Configuration;
use Nstaeger\CmsPluginFramework\Creator\WordpressCreator;
use Nstaeger\WpPostEmailNotification\WpPostEmailNotificationPlugin;
use Nstaeger\WpPostEmailNotification\Widget\SubscriptionWidget;

require __DIR__ . '/vendor/autoload.php';

$configuration = new Configuration(
    [
        'plugin_dir'           => __DIR__,
        'plugin_main_file'     => __FILE__,
        'plugin_url'           => plugin_dir_url(__FILE__),
        'controller_namespace' => "Nstaeger\\WpPostEmailNotification\\Controller",
        'option_prefix'        => 'wpps_', // TODO rename
        'rest_prefix'          => 'wpps_v1' // TODO rename
    ]
);

$plugin = new WpPostEmailNotificationPlugin($configuration, new WordpressCreator());

$plugin->asset()->addAsset(new AssetItem('js/bundle/frontend-widget.js'));

add_action(
    'widgets_init',
    function () {
        register_widget(SubscriptionWidget::class);
    },
    10,
    2
);

add_action(
    'transition_post_status',
    function ($new_status, $old_status, $post) use ($plugin) {
        if ($new_status == 'publish' && $old_status != 'publish') {
            $plugin->events()->fire('post-published', [$post->ID]);
        } else {
            if ($old_status == 'publish' && $new_status != 'publish') {
                $plugin->events()->fire('post-unpublished', [$post->ID]);
            }
        }
    },
    10,
    3
);
