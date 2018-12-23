/**
 *
 * Scripts Module
 *
 * Version: 1.1
 *
 * Compile CSS from Sass files
 *
 */
/* global module, require */
'use strict';
var concat = require('gulp-concat');
var minify = require('gulp-minify');
var rename = require('gulp-rename');

module.exports = function(gulp, plugins, config) {
    // Combine js files
    function bootstrapjs() {
        return gulp
            .src([
                config.baseDir + 'node_modules/bootstrap/js/dist/util.js',
                config.baseDir + 'node_modules/bootstrap/js/dist/alert.js',
                config.baseDir + 'node_modules/bootstrap/js/dist/button.js',
                // config.baseDir + 'node_modules/bootstrap/js/dist/carousel.js',
                config.baseDir + 'node_modules/bootstrap/js/dist/collapse.js',
                config.baseDir + 'node_modules/bootstrap/js/dist/dropdown.js',
                // config.baseDir + 'node_modules/bootstrap/js/dist/modal.js',
                config.baseDir + 'node_modules/bootstrap/js/dist/scrollspy.js'
                // config.baseDir + 'node_modules/bootstrap/js/dist/tab.js'
                // config.baseDir + 'node_modules/bootstrap/js/dist/tooltip.js'
                // config.baseDir + 'node_modules/bootstrap/js/dist/popover.js'
            ])
            .pipe(concat('bootstrap.js'))
            .pipe(gulp.dest(config.scripts));
    }
    // Create minified js
    function minifyjs() {
        // bootstrapjs has to be finished before minifyjs
        return gulp
            .src([config.scripts + '**/**/*.js', '!' + config.scripts + '**/**/*.min.js']) // exclude .min.js
            .pipe(
                minify({
                    ext: {
                        src: '.js',
                        min: [/(.*)\.js$/, '$1.min.js']
                    },
                    noSource: true
                })
            )
            .pipe(gulp.dest(config.scripts));
    }
    // Combine js files
    function combinejs() {
        // minifyjs has to be finished before combinejs
        return gulp
            .src([
                // file order is important !
                config.scripts + 'jquery-3.2.1.min.js',
                config.scripts + 'popper.min.js',
                config.scripts + 'bootstrap.min.js',
                config.scripts + 'plugins/loaders/pace.min.js',
                config.scripts + 'plugins/loaders/lazyload.min.js',
                config.scripts + 'plugins/nicescroll/jquery.nicescroll.min.js',
                config.scripts + 'project.min.js'
            ])
            .pipe(concat(config.baseCombinedName + '.min.js'))
            .pipe(gulp.dest(config.scripts));
    }
    // Combine defered js files
    function combinedeferjs() {
        // minifyjs has to be finished before combinejs
        return gulp
            .src([
                // file order is important !
                config.scripts + 'fontawesome-free-5.0.12/svg-with-js/js/fontawesome-all.min.js'
            ])
            .pipe(concat(config.baseCombinedDeferName + '.min.js'))
            .pipe(gulp.dest(config.scripts));
    }

    // main task
    return gulp.series(bootstrapjs, minifyjs, combinejs, combinedeferjs);
};
