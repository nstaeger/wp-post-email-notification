<?php

/**
 * Plugin Name: WP Post Subscription
 * Description: Send email notifications to subscribers when new posts are made
 * Version: 0.1.0
 * Author: Nicolai Stäger
 * Author URI: http://nstaeger.de
 */

use Nstaeger\Framework\Configuration;
use Nstaeger\Framework\Creator\WordpressCreator;
use Nstaeger\WpPostSubscription\Plugin;

require __DIR__ . '/vendor/autoload.php';

$configuration = new Configuration(
    [
        'plugin_dir'           => __DIR__,
        'plugin_main_file'     => __FILE__,
        'plugin_url'           => plugin_dir_url(__FILE__),
        'controller_namespace' => "Nstaeger\\WpPostSubscription\\Controller",
        'rest_prefix'          => 'wpps_v1'
    ]
);

$plugin = new Plugin($configuration, new WordpressCreator());

add_action(
    'transition_post_status',
    function ($new_status, $old_status, $post) use ($plugin) {
        if ($new_status == 'publish' && $old_status != 'publish') {
            $plugin->events()->fire('post-published', [$post->ID]);
        }
    },
    10,
    3
);
