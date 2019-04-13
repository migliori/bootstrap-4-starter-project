/* ------------------------------------------------------------------------------
 *
 *  # Gulp file
 *
 *  Gulp common tasks
 *
 *  Version: 1.1
 *  Latest update: Dec 23, 2018
 *
 * ---------------------------------------------------------------------------- */
/* global require */
'use strict';
var gulp = require('gulp');
var config = require('./gulp/config.json');
var plugins = require('gulp-load-plugins')();

/*==================================
=            site tasks            =
==================================*/

function getTask(task) {
    return require(config.tasksPath + '/' + task)(gulp, plugins, config);
}

gulp.task('sass', getTask('sass'));
gulp.task('scripts', getTask('scripts'));
gulp.task('critical', getTask('critical'));

// Watch for changes in files
function watchFiles() {
    gulp.watch(config.sass + '**/**/*.scss', getTask('sass'));
    gulp.watch([config.scripts + 'project.js'], getTask('scripts'));
}

gulp.task('watch', watchFiles);
