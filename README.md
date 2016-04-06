# WP Post Email Notification

A [WordPress](https://wordpress.org/) plugin sending email notifications to subscribers when a new post is published.

This plugin available on [wordpress.org](https://wordpress.org/plugins/wp-post-email-notification). Please use the version from wordpress.org for production.

## Developers

The version hosted on GitHub is the development version and by itself not able to run in your WordPress installation. To use this version, you will need [Git](http://git-scm.com/), [Node](http://nodejs.org/), [Composer](https://getcomposer.org/) and [Webpack](https://webpack.github.io/) installed and of course a running installation of [WordPress](https://wordpress.org/).

* `git clone git@github.com:nstaeger/wp-post-email-notification.git` into the plugins-folder of your WordPress installation
* `cd wp-post-email-notification/`
* `composer install` to install php dependencies
* `npm install` to install JS dependencies
* `webpack` to compile the JS files
* Activate the plugin in the WordPress plugin administration panel

[Gulp](http://gulpjs.com/) is used to build an installable bundle, but not required for development.
