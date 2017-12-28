<?php
@session_start();
include_once 'conf/conf.php';
?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="/favicon.ico">
        <title>Fixed top navbar example for Bootstrap</title>
        <!-- adaptative-images -->
        <script>
        document.cookie = 'resolution=' + Math.max(screen.width, screen.height) + ("devicePixelRatio" in window ? "," + devicePixelRatio : ",1") + '; path=/';
        </script>
        <?php include_once 'inc/page-head.php'; ?>
        <?php include_once 'inc/css-includes.php'; ?>
    </head>

    <body>
        <?php include_once 'inc/main-nav.php'; ?>
        <main role="main" class="container">
            <h1 class="text-center my-5">Sticky footer with fixed navbar</h1>
            <p class="text-justify lead mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <hr>
            <div class="row">
                <div class="col"><img data-src="holder.js/300x200" class="img-thumbnail mx-auto d-block" alt=""></div>
                <div class="col">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </div>

        </main>
        <?php include_once 'inc/page-footer.php'; ?>
        <?php include_once 'inc/js-includes.php'; ?>
    </body>

    </html>