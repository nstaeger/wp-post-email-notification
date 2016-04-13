<?php

namespace Nstaeger\WpPostEmailNotification\Widget;

use Nstaeger\CmsPluginFramework\Templating\TemplateRenderer;
use Nstaeger\WpPostEmailNotification\WpPostEmailNotificationPlugin;

class SubscriptionWidget extends \WP_Widget
{
    /**
     * @var TemplateRenderer
     */
    private $renderer;

    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        $this->renderer = WpPostEmailNotificationPlugin::getInstance()->renderer();

        $widget_ops = array(
            'classname'   => 'wp_post_email_notification',
            'description' => 'Allow people to subscribe to new post notifications.',
        );

        parent::__construct('SubscriptionWidget', 'Subscription Widget', $widget_ops);
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        echo $this->renderer->render("widget/widget", [
            'before_widget' => $args['before_widget'],
            'after_widget'  => $args['after_widget'],
            'before_title'  => $args['before_title'],
            'after_title'   => $args['after_title'],
            'title'         => !empty($instance['title']) ? $instance['title'] : false,
            'text'          => !empty($instance['text']) ? $instance['text'] : false
        ]);
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form($instance)
    {
        echo $this->renderer->render("widget/form", [
            'title_field_id'   => $this->get_field_id('title'),
            'title_field_name' => $this->get_field_name('title'),
            'title_value'      => !empty($instance['title']) ? esc_attr($instance['title']) : '',
            'text_field_id'    => $this->get_field_id('text'),
            'text_field_name'  => $this->get_field_name('text'),
            'text_value'       => !empty($instance['text']) ? esc_attr($instance['text']) : ''
        ]);
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance T he previous options
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        return [
            'title' => !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '',
            'text' => !empty($new_instance['text']) ? strip_tags($new_instance['text']) : ''
        ];
    }
}
