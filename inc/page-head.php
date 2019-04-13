    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
    $current_url = 'https://' . $_SERVER['HTTP_HOST'] . rtrim($_SERVER['REQUEST_URI'], '/');
    ?>
    <title><?php echo $meta['title']; ?></title>
    <meta name="description" content="<?php echo $meta['description']; ?>">
    <meta name="locations" content="Global">
    <meta name="robots" content="index, follow">
    <meta name="distribution" content="Global">
    <meta name="language" content="<?php echo SITE_LANG; ?>">
    <meta name="author" content="Gilles Migliori">
    <meta content="summary" name="twitter:card">
    <meta content="<?php echo $_SERVER['HTTP_HOST']; ?>" name="twitter:domain">
    <meta content="<?php echo $meta['title']; ?>" property="og:title">
    <meta content="<?php echo $meta['description']; ?>" property="og:description">
    <meta content="website" property="og:type">
    <meta content="My Website" property="og:site_name">
    <meta content="<?php echo $current_url ?>" property="og:url">
    <meta content="<?php echo LOCALE; ?>" property="og:locale">
    <meta content="your-fb-app-id" property="fb:app_id">
    <meta name="category" content="internet">
    <meta property="og:image" content="<?php echo BASE_URL . 'assets/images/screenshot.jpg'; ?>">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="400">
    <meta property="og:image:height" content="300">
    <link rel="icon" href="/favicon.ico">
    <link href="<?php echo $current_url; ?>" rel="canonical">

    <!-- Font loading - https://google-webfonts-helper.herokuapp.com/fonts  -->

    <link rel="preload" crossorigin="anonymous" href="/assets/fonts/overpass-v2-latin-300.woff2" as="font">
    <link rel="preload" crossorigin="anonymous" href="/assets/fonts/overpass-v2-latin-regular.woff2" as="font">
    <link rel="preload" crossorigin="anonymous" href="/assets/fonts/overpass-v2-latin-600.woff2" as="font">
    <link rel="preload" crossorigin="anonymous" href="/assets/fonts/raleway-v12-latin-italic.woff2" as="font">
    <style>
    /* overpass-300 - latin */
    @font-face {
      font-family: 'Overpass Light';
      font-display: swap;
      font-style: normal;
      font-weight: 300;
      src: local('Overpass Light'), local('Overpass-Light'),
           url('/assets/fonts/overpass-v2-latin-300.woff2') format('woff2'), /* Chrome 26+, Opera 23+, Firefox 39+ */
           url('/assets/fonts/overpass-v2-latin-300.woff') format('woff'); /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
           unicode-range: U+000-5FF; /* Latin glyphs */
    }
    /* overpass-regular - latin */
    @font-face {
      font-family: 'Overpass Regular';
      font-display: swap;
      font-style: normal;
      font-weight: 400;
      src: local('Overpass Regular'), local('Overpass-Regular'),
           url('/assets/fonts/overpass-v2-latin-regular.woff2') format('woff2'), /* Chrome 26+, Opera 23+, Firefox 39+ */
           url('/assets/fonts/overpass-v2-latin-regular.woff') format('woff'); /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
           unicode-range: U+000-5FF; /* Latin glyphs */
    }
    /* overpass-600 - latin */
    @font-face {
      font-family: 'Overpass SemiBold';
      font-display: swap;
      font-style: normal;
      font-weight: 600;
      src: local('Overpass SemiBold'), local('Overpass-SemiBold'),
           url('/assets/fonts/overpass-v2-latin-600.woff2') format('woff2'), /* Chrome 26+, Opera 23+, Firefox 39+ */
           url('/assets/fonts/overpass-v2-latin-600.woff') format('woff'); /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
           unicode-range: U+000-5FF; /* Latin glyphs */
    }
    /* raleway-italic - latin */
    @font-face {
      font-family: 'Raleway Italic';
      font-display: swap;
      font-style: italic;
      font-weight: 400;
      src: local('Raleway Italic'), local('Raleway-Italic'),
           url('/assets/fonts/raleway-v12-latin-italic.woff2') format('woff2'), /* Chrome 26+, Opera 23+, Firefox 39+ */
           url('/assets/fonts/raleway-v12-latin-italic.woff') format('woff'); /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
           unicode-range: U+000-5FF; /* Latin glyphs */
    }
    </style>
    <script type="application/ld+json"> {
    "@context" : "http://schema.org",
    "@type" : "HomeGoodsStore",
    "name":"My Website",
    "url":"https://www.heritage-de-france.fr",
    "image":"<?php echo BASE_URL . 'assets/images/screenshot.jpg'; ?>",
    "logo":"<?php echo BASE_URL . 'assets/images/logo.png'; ?>",
    "email":"me@my-website.com",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "121 My Street",
        "addressLocality": "CITY",
        "addressRegion": "COUNTRY",
        "postalCode": "11111"
      },
    "telephone":"3301010101",
    "openingHours": [
    "Mo-Sa 09:00-18:30"],
    "paymentAccepted":"Visa, Master Card",
    "priceRange": "€10 - €9500"
    } </script>
