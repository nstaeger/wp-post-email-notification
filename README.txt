=== WP Post Email Notification ===
Contributors: nstaeger
Tags: new, post, notification, email, subscribe, subscriber, newsletter, widget
Requires at least: 4.4.2
Tested up to: 4.9.6
Requires PHP: 5.6
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin sending email notifications to subscribers when a new post is published.


== Description ==

This plugin sends email-notifications to a list of subscribers (email address) whenever a new post is published. The list of subscribers is separated from the list of WordPress users.

To allow users to subscribe to the mailing-list, a widget is included that can be placed in the sidebar. The headline and a text of the widget can be modified and are displayed before the email-input field and the send button. The widget uses ajax to submit the entered e-mail address.

Within the administration area you get a reactive and clean overview of all subscribers and some additional settings, that fits perfectly into the user-experience of WordPress. You can delete or add subscribers manually as well as change the subject and body of the notification-email.

Sending the emails is regulated in jobs. A job is always responsible for sending emails to one new post. The job starts sending emails a minute after the post was published. Every job can be cancelled. The number of emails send within a run of the job can be modified in the options. The job is automatically deleted, once an email was send to all subscribers.

This plugin is open source and of course available on [GitHub](https://github.com/nstaeger/wp-post-email-notification).


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wp-post-email-notification` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the settings page "WP Post Email Notification" screen to configure the plugin.
4. Go to Design > Widgets to add a "Subscription Widget" to your sidebar to allow visitors to subscribe.


== Screenshots ==

1. The settings-page for the plugin within the administration area.
2. Adding a widget to allow subscriptions.


== Changelog ==

= 1.1.1 =

Published on 19th May 2018

* fix bug in registration of default options that prevents installation/activation

= 1.1.0 =

Published on 18th May 2018

* make job timeouts and batch size configurable
* framework update
* minor improvements

= 1.0.3 =

Published on 1st December 2016

* framework update
* minor improvements

= 1.0.2 =

Published on 11th May 2016

* fix(transit-post): only schedule job if post-type is 'post'
* fix(admin options view): update colspan for job-table, when no jobs are scheduled

= 1.0.1 =

Published on 13th April 2016

* Add screenshots
* Refactor html-class-name of widget

= 1.0.0 =

Published on 2nd April 2016

* Inital Release
