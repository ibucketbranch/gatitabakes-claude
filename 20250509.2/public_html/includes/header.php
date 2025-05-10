/**
 * Project: Gatita Bakes Online Order System
 * Title: header.php
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-06-09
 */
<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - <?php echo $page_title ?? 'Welcome'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        const baseURL = '<?php echo SITE_URL; ?>';
        const imagesPath = '<?php echo IMAGES_PATH; ?>';
    </script>
    <?php if (isset($additional_head)) echo $additional_head; ?>
</head>
<body>
    <?php if (!isset($hide_header) || !$hide_header): ?>
    <header>
        <!-- Add your header content here -->
    </header>
    <?php endif; ?> 