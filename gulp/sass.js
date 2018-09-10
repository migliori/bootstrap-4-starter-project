/**
 *
 * SASS Module
 *
 * Version: 1.0
 *
 * Compile CSS from Sass files
 *
 */

/* global module, require */
'use strict';

module.exports = function(gulp, plugins, config) {
    var autoprefixer = require('autoprefixer');
    var concat = require('gulp-concat');
    var cssnano = require('gulp-cssnano');
    var postcss = require('gulp-postcss');
    var rename = require('gulp-rename');
    var sass = require('gulp-sass');
    var sourcemaps = require('gulp-sourcemaps');

    // Compile scss files
    gulp.task('scss', function() {
        return gulp
            .src(config.sass + '/*.scss')
            .pipe(sass().on('error', sass.logError))
            .pipe(gulp.dest(config.css)); // create normal CSS
    });

    // add vendor prefixes - https://github.com/postcss/postcssk
    gulp.task('postcss', ['scss'], function() {
        // scss has to be finished before postcss
        return gulp
            .src(config.css + '/*.css')
            .pipe(sourcemaps.init())
            .pipe(postcss([autoprefixer({ browsers: ['last 4 versions'] })]))
            .pipe(sourcemaps.write('/maps'))
            .pipe(gulp.dest(config.css));
    });

    // optimise css - http://cssnano.co/
    gulp.task('cssnano', ['postcss'], function() {
        // postcss has to be finished before cssnano
        return gulp
            .src([config.css + '/*.css', '!' + config.css + '/*.min.css']) // exclude .min.css
            .pipe(cssnano({ zindex: false, minifyFontValues: false, discardUnused: false }))
            .pipe(
                rename({
                    suffix: '.min' // add *.min suffix
                })
            )
            .pipe(gulp.dest(config.css));
    });

    gulp.task('combinecss', ['cssnano'], function() {
        // cssnano has to be finished before combinecss
        return gulp
            .src([config.css + '/*.min.css', '!' + config.css + '/' + config.baseCombinedName + '.min.css'])
            .pipe(concat(config.baseCombinedName + '.min.css'))
            .pipe(gulp.dest(config.css));
    });

    // main task
    gulp.task('sass', ['scss', 'postcss', 'cssnano', 'combinecss']);
};
