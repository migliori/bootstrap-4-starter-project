<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
<script>
WebFont.load({
    google: {
        families: ['Roboto:300,400,500', 'Francois+One']
    }
});
</script>
<?php
if (ENVIRONMENT === 'development') {
    ?>
    <script type="text/javascript" src="<?php echo ASSETS_URL; ?>javascripts/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="<?php echo ASSETS_URL; ?>javascripts/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo ASSETS_URL; ?>javascripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo ASSETS_URL; ?>javascripts/plugins/misc/holder.min.js"></script>
    <script type="text/javascript" src="<?php echo ASSETS_URL; ?>javascripts/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo ASSETS_URL; ?>javascripts/project.js"></script>
    <?php
} else {
        ?>
        <script type="text/javascript" src="<?php echo ASSETS_URL; ?>javascripts/all.min.js"></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->

        <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109261132-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-109261132-1');
    </script> -->

        <!-- schema.org -->

        <!-- <script type="application/ld+json">
        {
            "@context": "http://www.schema.org",
            "@type": "product",
            "brand": "Miglisoft",
            "name": "DMCA Sender",
            "image": "https://www.hack-hunt.com/assets/images/screenshots/dmca-sender-home.jpg",
            "description": "Don't let hackers share your apps and softwares for free. DMCA Sender: Anti-piracy solution for sofware &amp; apps developers"
        }
    </script>
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Organization",
            "name": "Miglisoft",
            "url": "https://www.miglisoft.com",
            "logo": "https://www.miglisoft.com/assets/images/migli-logo.png",
            "sameAs": [
                "https://www.facebook.com/miglicodecanyon/",
                "https://twitter.com/miglisoft",
                "https://plus.google.com/+GillesMiglioriMigli",
                "https://www.linkedin.com/in/gilles-migliori-ab661626/"
            ]
        }
    </script> -->
        <?php
}