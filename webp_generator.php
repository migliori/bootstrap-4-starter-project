<?php
use WebPConvert\WebPConvert;

/* =============================================
    CHMOD vendor/rosell-dk/webp-convert/src/Converters/Binaries/cwebp-linux 0755
    to avoid any error
============================================= */

// Initialise your autoloader (this example is using Composer)
require 'vendor/autoload.php';
include_once 'conf/conf.php';

// ie: assets/images/articles/thumbs/sm/bague-diamants
$source = $_GET['file'] . '.' . $_GET['ext'];
$source_ext  = $_GET['ext'];
$destination = str_replace('assets/images/', 'assets/images/webp/', $source) . '.webp';

$success = WebPConvert::convertAndServe(ROOT . $source, ROOT . $destination, [
    // 'fail' => 'original',     // If failure, serve the original image (source).
    // 'fail' => 'report-as-image',
    'fail' => '404',        // If failure, respond with 404.
    'show-report' => false,  // Generates a report instead of serving an image
    'converters' => ['cwebp'],  // Specify conversion methods to use, and their order

        'converter-options' => [
            'cwebp' => [
                'try-common-system-paths' => false
            ]
        ]

    // Besides the specific options for convertAndServe(), you can also use the options for convert()
]);

// export PATH=$PATH:/usr/src/libwebp-1.0.2/bin
