<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - <?php echo $page_title ?? 'Welcome'; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        const baseURL = '<?php echo SITE_URL; ?>';
        const imagesPath = '<?php echo IMAGES_PATH; ?>';
    </script>
    <?php if (isset($additional_head)) echo $additional_head; ?>
</head>
<body>
    <?php if (!isset($hide_header) || !$hide_header): ?>
    <header class="hero-header">
        <nav class="hero-nav">
            <div class="hero-logo">
                <h1>Gatita Bakes</h1>
            </div>
            <div class="nav-links">
                <a href="/index.php#top" onclick="window.scrollTo({top:0,behavior:'smooth'});return false;">Home</a>
                <a href="/index.php#our-story">Our Story</a>
                <a href="/order-form.php">Order Now</a>
            </div>
        </nav>
    </header>
    <?php endif; ?> 