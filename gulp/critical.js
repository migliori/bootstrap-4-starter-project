/**
 *
 * Critical CSS Module
 *
 * Version: 1.1
 *
 * Creates "critical css" from html/php source files ("criticalSources")
 *
 * ******************
 * Critical PHP files
 * ******************
 *
 * Generates critical-[filename].min.css files in [config-css-dir]/critical/
 *
 * The generated css can be included with php in the php source files <head></head>.
 *          ie:
 *             include_once('path-to-css/critical/critical-filename.min.css');
 *
 * *******************
 * Critical HTML files
 * *******************
 *
 * Generates [filename].html files in /dist
 *
 * The generated files include inline critical css.
 */

/* global module, require */
/*jshint loopfunc:true */
'use strict';

var colors = require('ansi-colors');
var critical = require('critical').stream;
var del = require('del');
var fs = require('fs');
var log = require('fancy-log');
var mkdirp = require('mkdirp');
var request = require('sync-request');

module.exports = function(gulp, plugins, config) {
    var criticalSources = [
        {
            dir: config.baseDir,
            url: config.baseUrl,
            filter: ['.php'],
            ignoreCssRules: [/^--/],
            exclude: ['404.php', 'adaptive-images.php']
        }

        /* Add other directories here if you want
        ,{
            dir: config.baseDir + 'test/',
            url: config.baseUrl + 'test/',
            filter: ['.html'],
            ignoreCssRules: [/^--/],
            exclude: ['404.php', 'adaptive-images.php']
        }*/
    ];
    var currentSourceIndex = 0,
        options = {
            srcDir: criticalSources[currentSourceIndex].dir,
            url: criticalSources[currentSourceIndex].url,
            srcFilter: criticalSources[currentSourceIndex].filter,
            ignoreCssRules: criticalSources[currentSourceIndex].ignoreCssRules,
            srcExclude: criticalSources[currentSourceIndex].exclude
        },
        stream;
    // critical CSS
    function downloadHtml() {
        if (currentSourceIndex == 0) {
            log.info(colors.bgGreen('-------------- START CRITICAL -----------------'));
        }
        log.info(colors.green('______________DOWNLOAD HTML ' + currentSourceIndex + ' __ ' + options.srcDir));
        var files = fs.readdirSync(options.srcDir),
            url = options.url,
            exclude = options.srcExclude,
            filter = options.srcFilter,
            filename,
            match,
            urls = [];
        for (var i = 0; i < files.length; i++) {
            match = false;
            filename = files[i];
            filter.forEach(function(entry) {
                if (filename.indexOf(entry) > 0) {
                    match = true;
                }
            });
            if (match === true) {
                // exclude "exclude", "critical-" and folders
                if (exclude.indexOf(filename) === -1 && /^critical-/.test(filename) === false && /\.(.*)/.test(filename) === true) {
                    // test url before push
                    var res = request('GET', url + filename);
                    if (res.statusCode == 200) {
                        urls.push(url + filename);
                        log.info('-- found: ', url + filename);
                    } else {
                        log.error(colors.red(url + filename + " doesn't exist"));
                    }
                }
            }
        }
        if (urls.length < 1) {
            log.warn(colors.red('No URL found in ' + url));
            return;
        }
        mkdirp(options.srcDir + 'dist', function(err) {
            if (err) log.error(colors.red(err));
        });
        stream = plugins
            .download(urls)
            .pipe(
                plugins.rename(function(path) {
                    path.basename = 'critical-' + path.extname.replace(/\./, '') + '-' + path.basename; // add *.critical prefix
                    path.extname = '.html';
                })
            )
            .pipe(plugins.replace(/src="\/\//g, 'src="https://')) // replace src=// with src=http:// to avoid Chromium crash
            .pipe(gulp.dest(options.srcDir));

        return stream;
    }
    function criticalHtml() {
        log.info(colors.green('______________criticalHtml ' + currentSourceIndex + ' __ ' + options.srcDir));
        stream = gulp
            .src(options.srcDir + 'critical-html-*.html')
            .pipe(
                critical({
                    base: config.baseDir,
                    extract: false,
                    inline: true,
                    minify: true,
                    ignore: options.ignoreCssRules,
                    dimensions: [
                        {
                            width: 320,
                            height: 480
                        },
                        {
                            width: 768,
                            height: 1024
                        },
                        {
                            width: 1280,
                            height: 960
                        }
                    ]
                })
            )
            .on('error', function(err) {
                log.error(colors.red(err.message));
            })
            .pipe(
                plugins.rename(function(path) {
                    path.basename = path.basename.replace('critical-html-', '');
                })
            )
            .pipe(gulp.dest(options.srcDir + 'dist'));

        log.info(colors.bgGreen(options.srcDir + 'dist'));

        return stream;
    }
    function criticalPhp() {
        log.info(colors.green('______________criticalPhp ' + currentSourceIndex + ' __ ' + options.srcDir));
        stream = gulp
            .src(options.srcDir + 'critical-php-*.html')
            .pipe(
                critical({
                    base: config.baseDir,
                    extract: false,
                    inline: false,
                    minify: true,
                    ignore: options.ignoreCssRules,
                    penthouse: {
                        propertiesToRemove: []
                    },
                    dimensions: [
                        {
                            width: 320,
                            height: 480
                        },
                        {
                            width: 768,
                            height: 1024
                        },
                        {
                            width: 1280,
                            height: 960
                        }
                    ]
                })
            )
            .on('error', function(err) {
                log.error(colors.red(err.message));
            })
            .pipe(
                plugins.rename(function(path) {
                    path.basename = path.basename.replace('critical-php-', '') + '.min';
                })
            )
            .pipe(gulp.dest(config.css + 'critical'));

        return stream;
    }
    function deleteTemp() {
        log.info(colors.bgGreen('-------------- DELETE TEMP FILES -----------------'));
        stream = del([options.srcDir + 'critical-*.*'], { force: true });

        return stream;
    }

    function increment() {
        log.info(colors.bgGreen('-------------- INCREMENT -----------------'));
        currentSourceIndex++;
        options = {
            srcDir: criticalSources[currentSourceIndex].dir,
            url: criticalSources[currentSourceIndex].url,
            srcFilter: criticalSources[currentSourceIndex].filter,
            ignoreCssRules: criticalSources[currentSourceIndex].ignoreCssRules,
            srcExclude: criticalSources[currentSourceIndex].exclude
        };

        return stream;
    }

    function runCritical() {
        if (criticalSources.length == 1) {
            stream = gulp.series(downloadHtml, criticalHtml, criticalPhp, deleteTemp);
        } else if (criticalSources.length == 2) {
            stream = gulp.series(downloadHtml, criticalHtml, criticalPhp, deleteTemp, increment, downloadHtml, criticalHtml, criticalPhp, deleteTemp);
        }

        /* add ', increment, downloadHtml, criticalHtml, criticalPhp, deleteTemp' to gulp.series for each additional critical source */

        return stream;
    }

    // main task
    return runCritical();
};
