/**
 * Project: Gatita Bakes Online Order System
 * Title: Index
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-05-09
 */
<?php
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
    <nav class="main-nav">
        <div class="nav-container">
            <div class="logo">Gatita Bakes</div>
            <ul class="nav-links">
                <li><a href="#products">Our Breads</a></li>
                <li><a href="order-form.php" class="nav-cta">Order Now</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1>Artisan Bread<br>Made with Love</h1>
            <p>Fresh, handcrafted sourdough and artisan breads<br>baked daily in Sacramento</p>
            <a href="order-form.php" class="cta-button">Order Now</a>
        </div>
    </header>

    <section id="products" class="products">
        <div class="section-container">
            <h2>Our Artisan Collection</h2>
            <div class="product-grid">
                <?php foreach ($PRODUCTS as $id => $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo IMAGES_PATH . '/' . $product['image']; ?>" 
                             alt="<?php echo $product['name']; ?>">
                    </div>
                    <div class="product-info">
                        <h3><?php echo $product['name']; ?></h3>
                        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="products-cta">
                <a href="order-form.php" class="cta-button">Place Your Order</a>
            </div>
        </div>
    </section>

    <section id="contact" class="contact">
        <div class="section-container">
            <h2>Visit Us</h2>
            <div class="contact-grid">
                <div class="contact-info">
                    <h3>West Sacramento</h3>
                    <p>291 McDowell Lane<br>West Sacramento, CA 95605</p>
                    <p class="hours">Tuesday-Saturday, 7am-3pm</p>
                </div>
                <div class="contact-info">
                    <h3>Farmers Market</h3>
                    <p>Sacramento Central<br>Under the freeway on 8th & W</p>
                    <p class="hours">Sundays, 8am-12pm</p>
                </div>
                <div class="contact-info">
                    <h3>Get in Touch</h3>
                    <p>Email: <?php echo SITE_EMAIL; ?><br>
                    Phone: (555) 123-4567</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="section-container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
        </div>
    </footer>

    <!-- Only essential JavaScript -->
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