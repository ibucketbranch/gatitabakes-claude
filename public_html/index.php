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
        html {
            scroll-behavior: smooth;
        }
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
        header {
            background: #8b4513;
            color: #fff;
            padding: 0.5rem 0;
        }
        nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo h1 {
            font-size: 1.5em;
            margin: 0 1rem;
        }
        .nav-links {
            display: flex;
            gap: 2rem;
            margin-right: 1rem;
        }
        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1em;
            transition: color 0.2s;
        }
        .nav-links a:hover {
            color: #d4a373;
        }
        #our-story {
            max-width: 900px;
            margin: 60px auto 0 auto;
            padding: 2rem;
            background: #faf6f0;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(139, 69, 19, 0.06);
            min-height: 180px;
        }
        #our-story h2 {
            color: #8b4513;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
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
        <div class="hero-section" id="top">
            <img src="images/gatita-bakes-hero.jpg" alt="Gatita Bakes Hero" class="hero-image">
            <div class="hero-overlay">
                <h1>Welcome to Gatita Bakes</h1>
                <p>Artisan bread made with love and delight.</p>
            </div>
        </div>
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