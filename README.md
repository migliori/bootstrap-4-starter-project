# Bootstrap 4 starter project

**including [Gulp essential tasks](https://github.com/migliori/gulp-essentials)**

## Table of contents

* [Quick start](#quick-start)
* [What's included](#whats-included)
* [Features](#features)
  * [Configuration](#configuration)
  * [Gulp main tasks](#gulp-main-tasks)
  * [Bootstrap customization](#bootstrap-customization)
  * [Optimization](#optimization)
  * [Critical CSS for PHP files](#critical-css-for-php-files)
  * [Responsive images](#running-gulp-tasks)
* [Versionning](#versionning)
* [Authors](#authors)
* [License](#license)

## Quick start

### Prerequisites

* [Node.js](https://nodejs.org) installed
* PHP Server

### Installation

1. [Download the latest release.](https://github.com/migliori/bootstrap-4-starter-project/archive/master.zip)
   or Clone the repo: `git clone https://github.com/migliori/bootstrap-4-starter-project.git`

2. Unzip the package content to the root of your project

3. Open command prompt, navigate to your project folder and run [npm](https://www.npmjs.com/): `npm install` to install node_modules.

## What's included

Within the download you'll find the following directories and files:

```
bootstrap-4-starter-project/
├── .htaccess
├── adaptive-images.php
├── gulpfile.js
├── index.php
├── index-with-sidebar.php
├── package-lock.json
├── package.json
├── README.md
├── ai-cache/
├── conf/
│   ├── .htaccess
│   └── conf.php
├── assets/
│   ├── images/
│   ├── javascripts/
│   ├── sass/
│   └── stylesheets/
├── class/
│   ├── bootstrap
│   ├── common
│   └── lib
├── dist/
├── gulp/
│   ├── config.json
│   ├── critical.js
│   ├── images.js
│   ├── sass.js
│   └── scripts.js
└── inc/
    ├── css-includes.php
    ├── js-includes.php
    ├── main-nav.php
    ├── page-footer.php
    └── page-head.php
```

## Features

The Bootstrap 4 starter project allows to start your project with good practices, built-in features to compile your assets with maximum optimization for fast loading.

It includes some **Bootstrap 4 PHP Classes** to build Bootstrap Navs and Sidebars. The generated elements are rendered with **[Twig Template Engine](https://twig.symfony.com/)**

* ### Configuration
 The configuration file - `conf/conf.php` - defines global PHP constants for:
 * global URLs
 * global paths
 * email addresses
 * environment (development/production)
 * debug (false/true)
 * icons
 * default timezone
 * db connection
 * autoloader implementation for the php engine.

* ### Gulp main tasks
  Instructions available here: [Gulp essential tasks](https://github.com/migliori/gulp-essentials)

  * **sass**
  * **scripts**
  * **bootstrapjs** (part of scripts)
  * **images**
  * **critical** (critical css for html & php files)

* ### Bootstrap 4 PHP Classes

  * **Nav**
  * **Sidebar**

* ### Bootstrap 4 customization
  * **Bootstrap CSS** can be customized in `assets/sass/bootstrap.scss` (comment/uncomment to add/remove Bootstrap components)
  * **Bootstrap Javascript** can be customized in `gulp/scripts.js` => `bootstrapjs` (comment/uncomment to add/remove Bootstrap components)

* ### Optimization

  * **Localhost** is automagically detected in `conf/conf.php`.
    * On Localhost css and js files are served unminified and uncompiled.
  * **Production** server:
    * **CSS** files are compiled into a single `all.min.css` with preload.
    * **Javascript** files are compiled into a single `all.min.js` with defered loading.

  * **The PHP files are following the best practices for fast loading**:

    * Preload CSS
    * Defer Javascript
    * Google Webfonts Loader

   **These practices contribute to make the web faster and play nice with Critical CSS**.

* #### Critical CSS for PHP files:

  The critical CSS code is generated and saved in `[css-dir]/critical/[filename].min.css` where `[css-dir]` is the directory defined in `config.js` for your CSS files, and `[filename]` is the basename of the PHP source file.

  Critical CSS is loaded into each page's `<head>` with a PHP include in `inc/page-head.php`.

* #### Responsive images

  This package uses [Adaptive Images](http://adaptive-images.com/) to serve responsive images.

  Adaptive Images has been customized with 4 breakpoints to serve custom-width images or full-width images depending on the user's device screen:
  ```php
  /* adaptive-images.php
  break-points where images layout change.
  break-points will be used for images which match pattern   filename-[xs|sm|md|lg]-[0-9]{2}.[jpe?g|gif|png]
  ie: image-md-50.jpg will be :
      - half screen width on md and lg screens
      - full screen width on lower resolutions.
  */

  $breakpoints   = array(
      'lg' => 1200,
      'md' => 992,
      'sm' => 768,
      'xs' => 480
  );
  ```



## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/migliori/bootstrap-4-starter-project/tags).

## Authors

* **Gilles Migliori** - _Initial work_ - [Migliori](https://github.com/migliori)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
