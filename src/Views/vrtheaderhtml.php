<?php
namespace Vrainsietech\Vrtmvc\Controllers;
use Vrainsietech\Vrtmvc\Controllers\Seo;
$title = Seo::title();
$description = Seo::description();
$theme = Seo::themeColor();
$canorgurl = $ogurl = Seo::canorgurl();
$favicons = Seo::favicons();
$ogtitle = Seo::ogtitle();
$ogImageSchema = Seo::ogimage(); // Gives full url 'https://site/path/to/image'
$logo = Seo::logo(); // Full Url;

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Essential Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo $description;?>">
    <meta name="theme-color" content="<?php echo $theme;?>">
  
  <!-- Canonical Tag -->
    <link rel="canonical" href="<?php echo $canorgurl;?>">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $favicons;?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $favicons;?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $favicons;?>/favicon-16x16.png">
    <link rel="manifest" href="manifest.json">
    
   <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo $ogtitle;?>">
    <meta property="og:description" content="<?php echo $description;?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $canorgurl;?>">
    <meta property="og:image" content="<?php echo $ogimage;?>">
    
    <title><?php echo $title;?></title>
    
        <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebPage",
      "name": "<?php echo $title;?>",
      "description": "<?php echo $description;?>",
      "url": "<?php echo $canorgurl;?>",
      "image": "<?php echo $ogImageSchema;?>",
      "publisher": {
        "@type": "Organization",
        "name": "<?php echo $title;?>",
        "logo": {
          "@type": "ImageObject",
          "url": "<?php echo $logo;?>"
        }
      }
    }
    </script>
    
    
    
  <link rel="stylesheet" href='/vrtcss/base.css'>
  <link rel="stylesheet" href='/vrtcss/layout.css'>
  <link rel="stylesheet" href='/vrtcss/components.css'>
  <link rel="stylesheet" href='/vrtcss/utilities.css'>
  <script src='/vrtjs/vrtjs.js'></script>
  
</head>
<body>