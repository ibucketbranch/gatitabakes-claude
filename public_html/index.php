/**
 * Project: Gatita Bakes Online Order Form
 * Title: Main Ordering Page for Gatita Bakes Artisan Bread
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250510.2
 * Date: 2025-05-10
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
        html {
            scroll-behavior: smooth;
        }
        body {
            background: #faf6f0;
        }
        header.hero-header {
            background: #fff;
            color: #8b4513;
            box-shadow: 0 2px 8px rgba(139, 69, 19, 0.04);
            padding: 0;
        }
        .hero-nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 1rem 1.2rem 1rem;
        }
        .hero-logo h1 {
            font-size: 2.2em;
            font-family: 'Georgia', serif;
            margin: 0;
            letter-spacing: 1px;
        }
        .nav-links {
            display: flex;
            gap: 2.5rem;
        }
        .nav-links a {
            color: #8b4513;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.15em;
            transition: color 0.2s;
        }
        .nav-links a:hover {
            color: #d4a373;
        }
        .hero-image-full {
            width: 100vw;
            max-width: 100%;
            height: 340px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }
        #our-story {
            max-width: 900px;
            margin: 60px auto 0 auto;
            padding: 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(139, 69, 19, 0.06);
            min-height: 180px;
        }
        #our-story h2 {
            color: #8b4513;
            margin-bottom: 1rem;
        }
        footer {
            background: #8b4513;
            color: #fff;
            text-align: center;
            padding: 1.2rem 0 1rem 0;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <header class="hero-header">
        <nav class="hero-nav">
            <div class="hero-logo">
                <h1>Gatita Bakes</h1>
            </div>
            <div class="nav-links">
                <a href="#top" onclick="window.scrollTo({top:0,behavior:'smooth'});return false;">Home</a>
                <a href="#our-story">Our Story</a>
                <a href="order-form.php">Order Now</a>
            </div>
        </nav>
    </header>
    <main>
        <img src="images/hero-page-fullpage.png" alt="Gatita Bakes Hero" class="hero-image-full" id="top">
        <section id="our-story">
            <h2>Our Story</h2>
            <p><!-- Add Katerina's vision and story here. --></p>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
    </footer>
</body>
</html> 