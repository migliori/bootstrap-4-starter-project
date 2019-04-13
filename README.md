# Bootstrap 4 starter project

**including [Gulp essential tasks](https://github.com/migliori/gulp-essentials)**

## Table of contents

* [Overview](#overview)
* [Quick start](#quick-start)
* [What's included](#whats-included)
* [Features](#features)
  * [Configuration](#configuration)
  * [Gulp main tasks](#gulp-main-tasks)
  * [Bootstrap customization](#bootstrap-customization)
  * [Optimization](#optimization)
  * [Critical CSS for PHP files](#critical-css-for-php-files)
  * [WebP images](#webp-images)
* [Versionning](#versionning)
* [Authors](#authors)
* [License](#license)

## Overview

This project is a ready-to-use package to start a Bootstrap 4 project using a solid structure & efficient development tools such as Saas, Gulp, Altorouter, PHP Fast Cache, Twig.

It is based on a clean MVC workflow, and offers a basic HTML/JS/CSS structure with a sticky navbar, a sticky sidebar, a footer always at the bottom of the page.

It includes some **Bootstrap 4 PHP Classes** to build Bootstrap Navs and Sidebars. The generated elements are rendered with **[Twig Template Engine](https://twig.symfony.com/)**

It also uses smart optimization tools such as [WebP generator](https://github.com/rosell-dk/webp-convert), [LoadJs](https://github.com/muicss/loadjs) and generates Critical CSS with GULP.

## Quick start

### Prerequisites

* [Node.js](https://nodejs.org) installed for Gulp tasks
* PHP Server

### Installation

1. [Download the latest release.](https://github.com/migliori/bootstrap-4-starter-project/archive/master.zip)
   or Clone the repo: `git clone https://github.com/migliori/bootstrap-4-starter-project.git`

2. Unzip the package content to the root of your project

3. Open command prompt, navigate to your project folder
4.  run [npm](https://www.npmjs.com/): `npm install` to install node_modules.
5.  run [Composer](https://getcomposer.org/): `composer install` to install PHP dependencies


## What's included

Within the download you'll find the following directories and files:

```
bootstrap-4-starter-project/
├── .htaccess
├── composer.json
├── composer.lockjson
├── dropdown-page.php
├── gulpfile.js
├── home.php
├── index.php
├── LICENSE.md
├── nav-page.php
├── package-lock.json
├── package.json
├── README.md
├── webp_generator.php
├── conf/
│   ├── .htaccess
│   └── conf.php
├── assets/
│   ├── fonts/
│   ├── images/
│   ├── javascripts/
│   ├── sass/
│   └── stylesheets/
├── class/
│   ├── altorouter
│   ├── bootstrap
│   ├── common
│   └── lib
├── conf/
├── dist/
├── gulp/
│   ├── config.json
│   ├── critical.js
│   ├── images.js
│   ├── sass.js
│   └── scripts.js
├── i18n/
├── inc/
│── templates/
└── tmp/
```

## Features

* ### Routing
 * All requests to non-existent files are rewrited to `index.php` using .htaccess
 * `index.php` uses Altorouter to match the request, then includes the main PHP page

* ### Configuration
* The main configuration file - `conf/conf.php` - defines global PHP constants for:
  * global URLs
  * global paths
  * environment (development/production)
  * debug (false/true)
  * icons
  * db connection
  * autoloader implementation for the php engine.
* An additional configuration file - `conf/user-conf.php` - defines customizable PHP constants for:
  * PHP Cache duration
  * default timezone
  * language settings
  * others

* ### PHP Cache
 * PHP Cache is used only in `production` environment
 * environment & cache duration are defined in `conf/user-conf.php`

* ### Gulp main tasks
  Instructions available here: [Gulp essential tasks](https://github.com/migliori/gulp-essentials)

  * **sass**
  * **scripts**
  * **bootstrapjs** (part of scripts)
  * **images**
  * **critical** (critical css for html & php files)

* ### Bootstrap 4 PHP Classes

  * **Nav**
  * **Navbar**
  * **Sidebar**

* ### Bootstrap 4 customization
  * **Bootstrap CSS** can be customized in `assets/sass/bootstrap.scss` (comment/uncomment to add/remove Bootstrap components)
  * **Bootstrap Javascript** can be customized in `gulp/scripts.js` => `bootstrapjs` (comment/uncomment to add/remove Bootstrap components)

* ### Optimization

  * **Localhost** is automagically detected in `conf/conf.php`.
    * On Localhost css and js files are served unminified and uncompiled.
  * **Production** server:
    * **CSS** files are compiled into a single `all.min.css` with preload.
    * **Javascript** dependencies are minified and loaded with `LoadJs` asynchronously - definitely the best way to load JS dependencies.

  * **The main PHP pages are following the best practices for fast loading**:

    * Preload CSS
    * Defer Javascript
    * Google Webfonts Loader

   **These practices contribute to make the web faster and play nice with Critical CSS**.

* #### Critical CSS for PHP files:

  The critical CSS code is generated and saved in `[css-dir]/critical/[filename].min.css` where `[css-dir]` is the directory defined in `config.js` for your CSS files, and `[filename]` is the basename of the PHP source file.

  GULP Critical generates your critical CSS, you have to copy/paste it into your pages.

* #### WebP images

  We use [WebP convert](https://github.com/rosell-dk/webp-convert) to serve WebP images - all's configured, it works on the fly.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/migliori/bootstrap-4-starter-project/tags).

## Authors

* **Gilles Migliori** - _Initial work_ - [Migliori](https://github.com/migliori)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
