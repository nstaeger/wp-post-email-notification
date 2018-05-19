<?php

/**
 * Plugin Name: WP Post Email Notification
 * Description: Send email notifications to subscribers when a new post is published
 * Version: 1.1.1
 * Author: Nicolai Stäger
 * Author URI: http://nstaeger.de
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

use Nstaeger\CmsPluginFramework\Item\AssetItem;
use Nstaeger\CmsPluginFramework\Configuration;
use Nstaeger\CmsPluginFramework\Creator\WordpressCreator;
use Nstaeger\WpPostEmailNotification\WpPostEmailNotificationPlugin;

defined('ABSPATH') or die('No script kiddies please!');

require __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/config.php';

$plugin = new WpPostEmailNotificationPlugin(new Configuration($config), new WordpressCreator());

$plugin->permission()->registerPermissionMapping('can_manage', 'manage_options');
$plugin->asset()->addAsset(new AssetItem('js/bundle/frontend-widget.js'));

add_action(
    'widgets_init',
    function () {
        register_widget('Nstaeger\WpPostEmailNotification\Widget\SubscriptionWidget');
    },
    10,
    2
);

add_action(
    'transition_post_status',
    function ($new_status, $old_status, $post) use ($plugin) {
        if ($post->post_type != 'post') {
            return;
        }

        if ($new_status == 'publish' && $old_status != 'publish') {
            $plugin->events()->fire('post-published', [$post->ID]);
        } elseif ($old_status == 'publish' && $new_status != 'publish') {
            $plugin->events()->fire('post-unpublished', [$post->ID]);
        }
    },
    10,
    3
);
