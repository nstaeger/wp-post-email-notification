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
        $this->ajax()->registerEndpoint('job', 'GET', 'AdminJobController@get');
        $this->ajax()->registerEndpoint('subscribe', 'POST', 'FrontendSubscriberController@post', true);

        $this->events()->on('loaded', array($this, 'sendNotifications'));
        $this->events()->on('post-published', array($this, 'postPublished'));
    }

    public function activate()
    {
        $this->jobs()->createTable();
        $this->subscriber()->createTable();
    }

    public function deactivate()
    {
        $this->jobs()->dropTable();
        $this->subscriber()->dropTable();
    }

    /**
     * @return JobModel
     */
    public function jobs()
    {
        return $this->make(JobModel::class);
    }

    public function postPublished($id)
    {
        $this->jobs()->createNewJob($id);
    }

    public function sendNotifications()
    {
        $numberOfMails = 1;
        $jobs = $this->jobs()->getNextJob();

        if (empty($jobs)) {
            return;
        }

        foreach ($jobs as $job) {
            $recipients = $this->subscriber()->getEmails($job['offset'], $numberOfMails);

            if (!empty($recipients)) {
                $post = get_post($job['post_id']);

                $author = get_the_author_meta('display_name', $post->post_author);
                $title = $post->post_title;
                $permalink = get_permalink($post->ID);
                $subject = sprintf('New Post: %s', $title);
                $message = sprintf(
                    '%s published a new post named %s. Access it here: %s',
                    $author,
                    $title,
                    $permalink
                );
                $headers[] = '';

                foreach ($recipients as $recipient) {
                    wp_mail([$recipient['email']], $subject, $message, $headers);
                }
            }

            if (sizeof($recipients) < $numberOfMails) {
                $this->jobs()->completeJob($job['id']);
            }
            else {
                $this->jobs()->rescheduleWithNewOffset($job['id'], sizeof($recipients));
            }
        }
    }

    /**
     * @return SubscriberModel
     */
    public function subscriber()
    {
        return $this->make(SubscriberModel::class);
    }
}
