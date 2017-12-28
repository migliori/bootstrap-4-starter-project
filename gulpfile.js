/* ------------------------------------------------------------------------------
*
*  # Gulp file
*
*  Gulp common tasks
*
*  Version: 1.0
*  Latest update: Dec 09, 2017
*
* ---------------------------------------------------------------------------- */

/* global require */
'use strict';

var gulp = require('gulp');
var config = require('./gulp/config.json');
var plugins = require('gulp-load-plugins')();
var runSequence = require('run-sequence');

require(config.tasksPath + '/critical')(gulp, plugins, config);
require(config.tasksPath + '/images')(gulp, plugins, config);
require(config.tasksPath + '/sass')(gulp, plugins, config);
require(config.tasksPath + '/scripts')(gulp, plugins, config);

// Watch for changes in files
gulp.task('watch', function() {
    // Watch .scss files
    gulp.watch(config.sass + '**/**/*.scss', ['sass']);
    // Watch .js files
    gulp.watch(config.scripts + '**/**/*.js', ['scripts']);
    // Watch image files
    gulp.watch(config.images + 'images/**/*', ['images']);
});

// Default Task
gulp.task('default', ['watch']);

// Dist Task
gulp.task('dist', function() {
    runSequence('sass', 'scripts', 'images', 'critical');
});
