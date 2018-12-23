/**
 *
 * SASS Module
 *
 * Version: 1.1
 *
 * Compile CSS from Sass files
 *
 */

/* global module, require */
'use strict';

var autoprefixer = require('autoprefixer');
var concat = require('gulp-concat');
var cssnano = require('gulp-cssnano');
var postcss = require('gulp-postcss');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var strip = require('gulp-strip-comments');

module.exports = function(gulp, plugins, config) {
    // Compile scss files
    function runSass() {
        return gulp
            .src(config.sass + '*.scss')
            .pipe(sourcemaps.init())
            .pipe(sass().on('error', sass.logError))
            .pipe(sourcemaps.write('maps'))
            .pipe(gulp.dest(config.css)); // create normal CSS
    }

    // add vendor prefixes - https://github.com/postcss/postcssk
    function runPostcss() {
        // scss has to be finished before postcss
        return gulp
            .src([config.css + '*.css', '!' + config.css + '*.min.css'])
            .pipe(sourcemaps.init({ loadMaps: true }))
            .pipe(postcss([autoprefixer({ browsers: ['last 4 versions'] })]))
            .pipe(sourcemaps.write('maps'))
            .pipe(gulp.dest(config.css));
    }

    // optimise css - http://cssnano.co/
    function runCssnano() {
        // postcss has to be finished before cssnano
        return gulp
            .src([config.css + '*.css', '!' + config.css + '*.min.css']) // exclude .min.css
            .pipe(cssnano({ zindex: false }))
            .pipe(
                rename({
                    suffix: '.min' // add *.min suffix
                })
            )
            .pipe(strip.text({ ignore: /url\([\w\s:\/=\-\+;,]*\)/g }))
            .pipe(gulp.dest(config.css));
    }

    function runCombinecss() {
        // cssnano has to be finished before combinecss
        return gulp
            .src([config.css + '*.min.css', '!' + config.css + config.baseCombinedName + '.min.css'])
            .pipe(concat(config.baseCombinedName + '.min.css'))
            .pipe(gulp.dest(config.css));
    }

    // main task
    return gulp.series(runSass, runPostcss, runCssnano, runCombinecss);
};
