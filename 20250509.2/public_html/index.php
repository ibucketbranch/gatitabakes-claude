/**
 * Project: Gatita Bakes Online Order System
 * Title: Index
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-05-09
 */
<?php
include_once 'nocache.php'; // Prevent caching
$page_title = 'Gatita Bakes - Artisan Bread';
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header Navigation -->
    <header class="site-header">
        <div class="logo">Gatita Bakes</div>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#our-story">Our Story</a></li>
                <li><a href="order-form.php">Order Now</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="hero-content">
            <h1>Welcome to Gatita Bakes</h1>
            <p>Fresh, artisan bread and pastries made with love.</p>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="container">
            <h2>Welcome to Gatita Bakes</h2>
            <p>Artisan bread made with love and care</p>
            <a href="order-form.php" class="order-now-btn">Order Now</a>
        </div>
    </section>

    <!-- Product Section -->
    <section class="product-section" id="products">
        <div class="container">
            <h2>Our Artisan Collection</h2>
            <div class="product-grid">
                <?php foreach ($PRODUCTS as $id => $product): ?>
                <div class="product-card">
                    <img src="<?php echo IMAGES_PATH . '/' . $product['image']; ?>" 
                         alt="<?php echo $product['name']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                    <a href="order-form.php" class="add-to-cart">Add to Cart</a>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="pagination-dots">
                <span class="dot active"></span>
                <span class="dot"></span>
            </div>
            <div class="order-button-container">
                <a href="order-form.php" class="order-now-btn">Order Now</a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <h2>Contact Us</h2>
            <div class="contact-details">
                <p><strong>Email:</strong> <?php echo SITE_EMAIL; ?></p>
                <p><strong>Phone:</strong> (555) 123-4567</p>
                <p><strong>Hours:</strong> Tuesday-Saturday, 7am-3pm</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>

<style>
.hero-section {
    position: relative;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto 40px auto;
    overflow: hidden;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
}
.hero-image {
    width: 100%;
    height: 340px;
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