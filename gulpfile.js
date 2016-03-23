/**
 * Popular Tasks
 * -------------
 *
 * gulp build
 * gulp clean
 */

var del  = require('del'),
    gulp = require('gulp');


/**
 * Clean the dist folder
 */
gulp.task('clean', function (cb) {
    del(['_dist'], cb);
});

/**
 * Build the theme to the _dist-folder
 */
gulp.task('build', ['clean'], function () {
    return gulp.src([
            '**',
        ])
        .pipe(gulp.dest('_dist'));
});