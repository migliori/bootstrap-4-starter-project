<script src="<?php echo ASSETS_URL; ?>javascripts/loadjs.min.js"></script>
<?php if (ENVIRONMENT === 'development') { ?>
<script async defer src="<?php echo ASSETS_URL; ?>javascripts/project.js"></script>
<?php } else { ?>
    <script async defer src="<?php echo ASSETS_URL; ?>javascripts/project.min.js"></script>
<?php } ?>
<script async defer src="<?php echo ASSETS_URL; ?>javascripts/fontawesome-free-5.8.1-web/js/regular.min.js" data-auto-replace-svg="nest"></script>
<script async defer src="<?php echo ASSETS_URL; ?>javascripts/fontawesome-free-5.8.1-web/js/fontawesome.min.js"></script>
