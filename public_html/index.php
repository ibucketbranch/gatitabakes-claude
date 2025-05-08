<?php
// Include required files
require_once 'includes/config.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatita Bakes - Artisan Bread Orders</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/order-form.css">
    <link rel="stylesheet" href="css/carousel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        // This can be updated when moving to production
        const baseURL = window.location.origin;
    </script>
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
            <h2>Our Artisan Collection</h2>
            <div class="carousel-container">
                <!-- First set of products -->
                <div class="product-slide active">
                    <div class="product-grid">
                        <div class="product-card">
                            <div class="placeholder-img">Plain Sourdough</div>
                            <img src="images/Plain-Sourdough-Loaf.jpg" 
                                 alt="Plain Sourdough"
                                 onload="this.previousElementSibling.style.display='none'"
                                 onerror="this.style.display='none'">
                            <h3>Plain Sourdough</h3>
                            <p>$8.00</p>
                            <button class="add-to-cart" data-id="plain-sourdough" data-price="8.00">Add to Cart</button>
                        </div>
                        <div class="product-card">
                            <div class="placeholder-img">Everything Sourdough</div>
                            <img src="images/Everything-Sourdough-Loaf.jpg" 
                                 alt="Everything Sourdough"
                                 onload="this.previousElementSibling.style.display='none'"
                                 onerror="this.style.display='none'">
                            <h3>Everything Sourdough</h3>
                            <p>$9.00</p>
                            <button class="add-to-cart" data-id="everything-sourdough" data-price="9.00">Add to Cart</button>
                        </div>
                        <div class="product-card">
                            <div class="placeholder-img">Plain Bagels</div>
                            <img src="images/Plain-Bagels.png" 
                                 alt="Plain Bagels"
                                 onload="this.previousElementSibling.style.display='none'"
                                 onerror="this.style.display='none'">
                            <h3>Plain Bagels</h3>
                            <p>$3.00</p>
                            <button class="add-to-cart" data-id="plain-bagels" data-price="3.00">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Second set of products -->
                <div class="product-slide">
                    <div class="product-grid">
                        <div class="product-card">
                            <div class="placeholder-img">Rosemary Sourdough</div>
                            <img src="images/Rosemary-Sourdough-Loaf.png" 
                                 alt="Rosemary Sourdough"
                                 onload="this.previousElementSibling.style.display='none'"
                                 onerror="this.style.display='none'">
                            <h3>Rosemary Sourdough</h3>
                            <p>$9.00</p>
                            <button class="add-to-cart" data-id="rosemary-sourdough" data-price="9.00">Add to Cart</button>
                        </div>
                        <div class="product-card">
                            <div class="placeholder-img">Jalapeño Cheese Bagels</div>
                            <img src="images/Cheese-Jalapeńo-Bagels.png" 
                                 alt="Jalapeño Cheese Bagels"
                                 onload="this.previousElementSibling.style.display='none'"
                                 onerror="this.style.display='none'">
                            <h3>Jalapeño Cheese Bagels</h3>
                            <p>$3.50</p>
                            <button class="add-to-cart" data-id="jalapeno-cheese-bagels" data-price="3.50">Add to Cart</button>
                        </div>
                        <div class="product-card">
                            <div class="placeholder-img">Garlic Sourdough</div>
                            <img src="images/Plain-Sourdough-Loaf.jpg" 
                                 alt="Garlic Sourdough"
                                 onload="this.previousElementSibling.style.display='none'"
                                 onerror="this.style.display='none'">
                            <h3>Garlic Sourdough</h3>
                            <p>$9.00</p>
                            <button class="add-to-cart" data-id="garlic-sourdough" data-price="9.00">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Carousel Navigation -->
                <div class="carousel-nav">
                    <button class="carousel-arrow carousel-prev" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="carousel-dots">
                        <span class="dot active"></span>
                        <span class="dot"></span>
                    </div>
                    <button class="carousel-arrow carousel-next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </section>

        <section id="order" class="order-section">
            <h2>Place Your Order</h2>
            <form id="order-form" class="order-form">
                <div class="form-columns">
                    <div class="form-column">
                        <h3>Contact Information</h3>
                        <div class="form-group">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first-name" required>
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last-name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Mobile Phone</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>

                        <h3>Order Type</h3>
                        <div class="form-group order-type">
                            <div class="radio-group">
                                <input type="radio" id="pickup" name="order_type" value="pickup" checked>
                                <label for="pickup">Pickup</label>
                                <input type="radio" id="delivery" name="order_type" value="delivery">
                                <label for="delivery">Delivery</label>
                            </div>
                        </div>

                        <div id="pickup-location-fields">
                            <div class="form-group">
                                <label for="pickup-location">Pickup Location</label>
                                <select id="pickup-location" name="pickup-location" required>
                                    <option value="">Select pickup location</option>
                                    <option value="location1">123 Bakery Street, San Francisco</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pickup-notes">Notes for Pickup</label>
                                <textarea id="pickup-notes" name="pickup-notes"></textarea>
                            </div>
                        </div>

                        <div id="delivery-address-fields" style="display: none;">
                            <div class="form-group">
                                <label for="delivery-address">Street Address</label>
                                <input type="text" id="delivery-address" name="delivery-address">
                            </div>
                            <div class="form-group">
                                <label for="delivery-unit">Apt/Suite/Unit</label>
                                <input type="text" id="delivery-unit" name="delivery-unit">
                            </div>
                            <div class="form-group">
                                <label for="delivery-city">City</label>
                                <input type="text" id="delivery-city" name="delivery-city">
                            </div>
                            <div class="form-group">
                                <label for="delivery-notes">Delivery Instructions</label>
                                <textarea id="delivery-notes" name="delivery-notes"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-column">
                        <div id="cart-summary" class="cart-summary">
                            <h3>Order Summary</h3>
                            <div class="cart-items">
                                <!-- Cart items will be inserted here by JavaScript -->
                            </div>
                            <div id="empty-cart-message">Your cart is empty. Add some delicious bread!</div>
                            <div class="cart-total">Total: $0.00</div>
                        </div>

                        <div class="payment-info">
                            <h3>Payment Information</h3>
                            <p>Payment via Venmo: @katielawendowski</p>
                            <p class="payment-note">Payment instructions will be sent with your order confirmation.</p>
                        </div>

                        <button type="submit" class="submit-order" id="submit-order">Submit Order</button>
                    </div>
                </div>
            </form>
        </section>

        <section id="contact" class="contact-section">
            <h2>Contact Us</h2>
            <div class="contact-info">
                <p><strong>Email:</strong> <?php echo SITE_EMAIL; ?></p>
                <p><strong>Phone:</strong> (555) 123-4567</p>
                <p><strong>Hours:</strong> Tuesday-Saturday, 7am-3pm</p>
                <p><strong>Location:</strong> 123 Bakery Street, San Francisco, CA 94110</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
    </footer>

    <!-- Update JavaScript references -->
    <script src="js/main.js"></script>
    <script src="js/carousel.js"></script>
    <script src="js/order-form.js"></script>
</body>
</html> 