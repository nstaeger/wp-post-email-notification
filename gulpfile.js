/**
 * Popular Tasks
 * -------------
 *
 * gulp build
 * gulp clean
 * gulp webpack
 */

var del     = require('del'),
    gulp    = require('gulp'),
    gutil   = require("gulp-util"),
    webpack = require('webpack');

var distDir = '_dist';

/**
 * Build plugin package
 */
gulp.task('build', ['clean', 'webpack'], function () {
    return gulp.src([
            '**',
            '!_dist{/**,}',
            '!_misc{/**,}',
            '!js/*',
            '!js/views/**',
            '!node_modules{/**,}',
            '!tmp{/**,}',
            '!.gitignore',
            '!composer.*',
            '!gulpfile.js',
            '!package.json',
            '!README.md',
            '!webpack.*'
        ])
        .pipe(gulp.dest(distDir + "/wp-post-email-notification"));
});

/**
 * Clean the dist folder
 */
gulp.task('clean', function (cb) {
    del([distDir]).then(cb());
});

/**
 * Run Webpack
 */
gulp.task("webpack", function (cb) {
    webpack(require('./webpack.config.js'), function (err, stats) {
        if (err) {
            throw new gutil.PluginError("webpack", err);
        }
        // gutil.log("[webpack]", stats.toString({}));
        cb();
    });
});
