<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatita Bakes - Artisan Bread Orders</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>Gatita Bakes</h1>
            </div>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#products">Our Breads</a></li>
                <li><a href="#order">Order Now</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="home" class="hero">
            <h2>Welcome to Gatita Bakes</h2>
            <p>Artisan bread made with love and care</p>
            <a href="#order" class="cta-button">Order Now</a>
        </section>

        <section id="products" class="products-section">
            <h2>Our Artisan Breads</h2>
            <div class="product-grid">
                <div class="product-card">
                    <img src="images/Plain-Sourdough-Loaf.jpg" alt="Plain Sourdough Loaf">
                    <h3>Plain Sourdough</h3>
                    <p>Classic sourdough with perfect crust and tender crumb</p>
                    <span class="price">$8.00</span>
                    <button class="add-to-cart" data-product="plain-sourdough">Add to Cart</button>
                </div>
                <div class="product-card">
                    <img src="images/Everything-Sourdough-Loaf.jpg" alt="Everything Sourdough">
                    <h3>Everything Sourdough</h3>
                    <p>Our signature sourdough with everything seasoning</p>
                    <span class="price">$9.00</span>
                    <button class="add-to-cart" data-product="everything-sourdough">Add to Cart</button>
                </div>
                <div class="product-card">
                    <img src="images/Rosemary-Sourdough-Loaf.png" alt="Rosemary Sourdough">
                    <h3>Rosemary Sourdough</h3>
                    <p>Aromatic rosemary infused into our classic sourdough</p>
                    <span class="price">$9.00</span>
                    <button class="add-to-cart" data-product="rosemary-sourdough">Add to Cart</button>
                </div>
                <div class="product-card">
                    <img src="images/Plain-Bagels.png" alt="Plain Bagels">
                    <h3>Plain Bagels</h3>
                    <p>Traditional hand-rolled and boiled bagels</p>
                    <span class="price">$3.00</span>
                    <button class="add-to-cart" data-product="plain-bagels">Add to Cart</button>
                </div>
                <div class="product-card">
                    <img src="images/Cheese-Jalapeńo-Bagels.png" alt="Jalapeño Cheese Bagels">
                    <h3>Jalapeño Cheese Bagels</h3>
                    <p>Spicy jalapeños and sharp cheddar cheese</p>
                    <span class="price">$3.50</span>
                    <button class="add-to-cart" data-product="jalapeno-cheese-bagels">Add to Cart</button>
                </div>
            </div>
        </section>

        <section id="order" class="order-section">
            <h2>Place Your Order</h2>
            <form id="order-form" class="order-form">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="pickup-date">Pickup Date</label>
                    <input type="date" id="pickup-date" name="pickup-date" required>
                </div>
                <div class="form-group">
                    <label for="special-instructions">Special Instructions</label>
                    <textarea id="special-instructions" name="special-instructions"></textarea>
                </div>
                <div class="order-summary">
                    <h3>Your Order</h3>
                    <div id="cart-items"></div>
                    <div class="total">Total: <span id="cart-total">$0.00</span></div>
                </div>
                <button type="submit" class="submit-order">Place Order</button>
            </form>
        </section>

        <section id="contact" class="contact-section">
            <h2>Contact Us</h2>
            <div class="contact-info">
                <p><strong>Email:</strong> orders@gatitabakes.com</p>
                <p><strong>Phone:</strong> (555) 123-4567</p>
                <p><strong>Hours:</strong> Tuesday-Saturday, 7am-3pm</p>
                <p><strong>Location:</strong> 123 Bakery Street, San Francisco, CA 94110</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Gatita Bakes. All rights reserved.</p>
    </footer>

    <script src="js/main.js"></script>
</body>
</html> 