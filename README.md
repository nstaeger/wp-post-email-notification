# wp-post-email-notification

A [WordPress](https://wordpress.org/) plugin sending email notifications to subscribers when a new post is published.

The plugin will be available via wordpress.org very soon.

More to come...

## Develpers

You will need [Git](http://git-scm.com/), [Node](http://nodejs.org/), [Composer](https://getcomposer.org/) and [Webpack](https://webpack.github.io/) installed, before you start. Of course you need a running installation of [WordPress](https://wordpress.org/).

* `git clone git@github.com:nstaeger/wp-post-email-notification.git` into the plugins-folder of your WordPress installation
* `composer install` to install php dependencies
* `npm install` to install JS dependencies
* `webpack` to compile the JS files
* Activate the plugin in the WordPress plugin administration panel

[Gulp](http://gulpjs.com/) is used to build an installable bundle, but not required for development.