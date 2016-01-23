<?php

/**
 * Plugin Name: WP Post Subscription
 * Description: Send email notifications to subscribers when new posts are made
 * Version: 0.1.0
 * Author: Nicolai Stäger
 * Author URI: http://nstaeger.de
 */

use Nstaeger\WpPostSubscription\Plugin;

$path = __DIR__;
$loader = require $path . '/vendor/autoload.php';

$plugin = new Plugin($path, $GLOBALS['wpdb']);

register_activation_hook(__FILE__, array($plugin, 'activate'));
register_uninstall_hook(__FILE__, array($plugin, 'uninstall'));

add_action('admin_menu', function() use ($plugin) {
    add_management_page(
        'WP Post Subscription Options',
        'WP Post Subscription',
        'manage_options',
        'wp-ps-options',
        array($plugin, 'renderOptionsPage')
    );
});

add_action('admin_enqueue_scripts', function($hook) {
    if (strpos($hook, 'wp-ps-options') !== false) {
        wp_enqueue_script('wp-ps-options', plugin_dir_url(__FILE__) . 'js/bundle/admin-options.js');
    }
});

add_action('wp_ajax_ps_ajax', function() use ($plugin) {
    $plugin->handleAjaxRequest();
});
