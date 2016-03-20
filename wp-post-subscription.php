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

$configuration = new Configuration([
    'plugin_dir' => __DIR__,
    'plugin_url' => plugin_dir_url(__FILE__),
    'controller_namespace' => "Nstaeger\\WpPostSubscription\\Controller",
    'rest_prefix' => 'wpps_v1'
]);

$plugin = new Plugin($configuration, new WordpressCreator());

$plugin->menu()->registerAdminMenuItem('WP Post Subscription', 'AdminPageController@optionsPage');
$plugin->ajax()->registerEndpoint('subscriber', 'GET', 'AdminAjaxController@get');
$plugin->ajax()->registerEndpoint('subscriber', 'POST', 'AdminAjaxController@post');
$plugin->ajax()->registerEndpoint('subscriber', 'DELETE', 'AdminAjaxController@delete');

//$plugin = new Plugin($url, $dir, $GLOBALS['wpdb']);
//
//register_activation_hook(__FILE__, array($plugin, 'activate'));
//register_uninstall_hook(__FILE__, array($plugin, 'uninstall'));
//
//add_action('admin_menu', function() use ($plugin) {
//    add_management_page(
//        'WP Post Subscription Options',
//        'WP Post Subscription',
//        'manage_options',
//        'wp-ps-options',
//        array($plugin, 'renderOptionsPage')
//    );
//});
//
//add_action('wp_enqueue_scripts', function() use ($plugin) {
//    wp_enqueue_script('wp-ps-widget', $plugin->getUrl() . 'js/bundle/frontend-widget.js');
//    wp_localize_script('wp-ps-widget', 'ajaxurl', admin_url('admin-ajax.php'));
//});
//add_action('admin_enqueue_scripts', function($hook) use ($plugin) {
//    if (strpos($hook, 'wp-ps-options') !== false) {
//        wp_enqueue_script('wp-ps-options', $plugin->getUrl() . 'js/bundle/admin-options.js');
//    }
//});
//
//add_action('wp_ajax_ps_ajax', function() use ($plugin) {
//    $plugin->handleAjaxRequest();
//});
//add_action('wp_ajax_nopriv_ps_ajax', function() use ($plugin) {
//    $plugin->handleAjaxRequest();
//});
//
//add_action( 'widgets_init', function() {
//    register_widget('Nstaeger\\WpPostSubscription\\Widget\\SubscriptionWidget');
//});
