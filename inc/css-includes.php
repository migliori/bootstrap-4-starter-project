<?php
if (ENVIRONMENT === 'development') {
    ?>
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>stylesheets/bootstrap.css">
    <link href="<?php echo ASSETS_URL; ?>stylesheets/project.css" media="screen" rel="stylesheet" type="text/css" />
<?php
} else {
        ?>
    <link rel="preload" href="<?php echo ASSETS_URL; ?>stylesheets/all.min.css" as="style" onload="this.rel='stylesheet'">
    <noscript><link type="text/css" media="screen" rel="stylesheet" href="<?php echo ASSETS_URL; ?>stylesheets/all.min.css" /></noscript>
<?php
}
?>
