/**
 * Project: Gatita Bakes Online Order Form
 * Title: Main Ordering Page for Gatita Bakes Artisan Bread
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2025-09-05
 */
<?php
// Include required files
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatita Bakes - Artisan Bread Orders</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .hero-section {
            position: relative;
            width: 100%;
            max-width: 1200px;
            margin: 40px auto 40px auto;
            overflow: hidden;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            height: 340px;
        }
        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .hero-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: rgba(0,0,0,0.25);
            text-shadow: 0 2px 8px rgba(0,0,0,0.25);
        }
        .hero-overlay h1 {
            font-size: 2.8em;
            margin-bottom: 0.3em;
            letter-spacing: 2px;
        }
        .hero-overlay p {
            font-size: 1.3em;
            font-weight: 400;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>Gatita Bakes</h1>
            </div>
        </nav>
    </header>
    <main>
        <div class="hero-section">
            <img src="images/gatita-bakes-hero.jpg" alt="Gatita Bakes Hero" class="hero-image">
            <div class="hero-overlay">
                <h1>Welcome to Gatita Bakes</h1>
                <p>Artisan bread made with love and delight.</p>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
    </footer>
</body>
</html> 