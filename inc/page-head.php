<?php
// generate token for Content-Security-Policy
$cross_policy_token = bin2hex(openssl_random_pseudo_bytes(16));
?>
    <meta name="locations" content="Global">
    <meta name="robots" content="index, follow">
    <meta name="distribution" content="Global">
    <meta name="language" content="en">
    <meta name="author" content="<?php echo AUTHOR; ?>">
    <meta content="summary" name="twitter:card">
    <meta content="@twittername" name="twitter:creator">
    <meta content="https://www.domain.com" name="twitter:domain">
    <meta content="Website Main Title" property="og:title">
    <meta content="Website Main Description" property="og:description">
    <meta content="website" property="og:type">
    <meta content="Website Name" property="og:site_name">
    <meta content="logo.png" property="og:image">
    <meta content="<?php echo BASEURL; ?>" property="og:url">
    <meta content="en_GB" property="og:locale">
    <meta content="1234567891234567" property="fb:app_id">
    <meta name="category" content="internet">
    <link href="<?php echo BASEURL; ?>" rel="canonical">
    <meta property="og:image" content="<?php echo BASEURL; ?>assets/images/screenshot.jpg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1080">
    <meta property="og:image:height" content="810">
    <meta content="default-src 'self' https://www.google.com; style-src 'self' http://fonts.googleapis.com https://fonts.googleapis.com/ https://fonts.googleapis.com 'unsafe-inline'; img-src 'self' https://stats.g.doubleclick.net data: http://www.google-analytics.com; font-src data: 'self' https://fonts.gstatic.com http://fonts.googleapis.com http://fonts.gstatic.com; script-src 'self' 'unsafe-inline' https://ajax.googleapis.com https://www.google.com https://www.gstatic.com https://www.googletagmanager.com 'unsafe-eval' http://www.google-analytics.com https://ajax.cloudflare.com nonce-<?php echo $cross_policy_token; ?>" http-equiv="Content-Security-Policy">
    <?php
    $file_name = preg_replace('`\.[a-z]+`', '', $_SERVER['SCRIPT_NAME']);
    $critical_css_file = ROOT . 'assets/stylesheets/critical' . $file_name . '.min.css';
    if (file_exists($critical_css_file)) {
        echo '
<style type="text/css">
' . file_get_contents($critical_css_file) . '
</style>' . "\n";
    }
?>