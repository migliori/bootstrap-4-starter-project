/**
 *
 * Images Module
 *
 * Version: 1.0
 *
 * Optimize images to dest folder
 *
 */

/* global module, require */
/*jshint unused:false*/
'use strict';

module.exports = function(gulp, plugins, config) {
    var cache = require('gulp-cache');
    var imagemin = require('gulp-imagemin');

    // optimize images
    gulp.task('optimizeimages', function() {
        return gulp
            .src([config.imagesSrcFolder + '/**/*', '!' + config.imagesDistFolder + '/']) // exclude dist folder
            .pipe(plugins.cache(plugins.imagemin({ optimizationLevel: 5, progressive: true, interlaced: true })))
            .pipe(gulp.dest(config.imagesDistFolder));
    });

    // main task
    gulp.task('images', ['optimizeimages']);
};
