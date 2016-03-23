<?php

namespace Nstaeger\WpPostEmailNotification;

use Nstaeger\CmsPluginFramework\Configuration;
use Nstaeger\CmsPluginFramework\Creator\Creator;
use Nstaeger\CmsPluginFramework\Plugin;
use Nstaeger\WpPostEmailNotification\Model\JobModel;
use Nstaeger\WpPostEmailNotification\Model\SubscriberModel;

class WpPostEmailNotificationPlugin extends Plugin
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
        $this->ajax()->registerEndpoint('job', 'DELETE', 'AdminJobController@delete');
        $this->ajax()->registerEndpoint('subscribe', 'POST', 'FrontendSubscriberController@post', true);

        $this->events()->on('loaded', array($this, 'sendNotifications'));
        $this->events()->on('post-published', array($this, 'postPublished'));
        $this->events()->on('post-unpublished', array($this, 'postUnpublished'));
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

    public function postUnpublished($id)
    {
        $this->jobs()->removeJobsFor($id);
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

            if (sizeof($recipients) < $numberOfMails) {
                $this->jobs()->completeJob($job['id']);
            }
            else {
                $this->jobs()->rescheduleWithNewOffset($job['id'], sizeof($recipients));
            }

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
