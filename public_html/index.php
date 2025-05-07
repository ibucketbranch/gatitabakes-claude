<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug message
echo "Debug: Starting index.php<br>";

// Try including files
try {
    echo "Debug: About to include config.php<br>";
    require_once 'includes/config.php';
    echo "Debug: config.php included successfully<br>";
    
    echo "Debug: About to include functions.php<br>";
    require_once 'includes/functions.php';
    echo "Debug: functions.php included successfully<br>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
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
                    <span class="price"><?php echo format_price(8.00); ?></span>
                    <button class="add-to-cart" data-product="plain-sourdough">Add to Cart</button>
                </div>
                <div class="product-card">
                    <img src="images/Everything-Sourdough-Loaf.jpg" alt="Everything Sourdough">
                    <h3>Everything Sourdough</h3>
                    <p>Our signature sourdough with everything seasoning</p>
                    <span class="price"><?php echo format_price(9.00); ?></span>
                    <button class="add-to-cart" data-product="everything-sourdough">Add to Cart</button>
                </div>
                <div class="product-card">
                    <img src="images/Rosemary-Sourdough-Loaf.png" alt="Rosemary Sourdough">
                    <h3>Rosemary Sourdough</h3>
                    <p>Aromatic rosemary infused into our classic sourdough</p>
                    <span class="price"><?php echo format_price(9.00); ?></span>
                    <button class="add-to-cart" data-product="rosemary-sourdough">Add to Cart</button>
                </div>
                <div class="product-card">
                    <img src="images/Plain-Bagels.png" alt="Plain Bagels">
                    <h3>Plain Bagels</h3>
                    <p>Traditional hand-rolled and boiled bagels</p>
                    <span class="price"><?php echo format_price(3.00); ?></span>
                    <button class="add-to-cart" data-product="plain-bagels">Add to Cart</button>
                </div>
                <div class="product-card">
                    <img src="images/Cheese-Jalapeńo-Bagels.png" alt="Jalapeño Cheese Bagels">
                    <h3>Jalapeño Cheese Bagels</h3>
                    <p>Spicy jalapeños and sharp cheddar cheese</p>
                    <span class="price"><?php echo format_price(3.50); ?></span>
                    <button class="add-to-cart" data-product="jalapeno-cheese-bagels">Add to Cart</button>
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

                        <h3>Pickup Details</h3>
                        <div class="form-group">
                            <label for="pickup-date">Pickup Date</label>
                            <input type="date" id="pickup-date" name="pickup-date" required>
                        </div>
                        <div class="form-group">
                            <label for="pickup-time">Preferred Pickup Time</label>
                            <select id="pickup-time" name="pickup-time" required>
                                <option value="">Select a time</option>
                                <?php
                                foreach(get_pickup_times() as $value => $label) {
                                    echo "<option value=\"$value\">$label</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="special-instructions">Special Instructions</label>
                            <textarea id="special-instructions" name="special-instructions"></textarea>
                        </div>
                    </div>

                    <div class="form-column">
                        <div class="order-summary">
                            <h3>Your Order Summary</h3>
                            <div id="cart-items" class="cart-items">
                                <!-- Cart items will be inserted here by JavaScript -->
                            </div>
                            <div class="cart-totals">
                                <div class="subtotal">
                                    <span>Subtotal:</span>
                                    <span id="subtotal">$0.00</span>
                                </div>
                                <div class="tax">
                                    <span>Tax (8.5%):</span>
                                    <span id="tax">$0.00</span>
                                </div>
                                <div class="total">
                                    <span>Total:</span>
                                    <span id="cart-total">$0.00</span>
                                </div>
                            </div>
                            <div class="empty-cart-message" id="empty-cart-message">
                                Your cart is empty. Please add some delicious bread to your order!
                            </div>
                        </div>
                        <div class="payment-section">
                            <h3>Payment Method</h3>
                            <p class="payment-note">Payment will be collected at pickup. We accept:</p>
                            <ul class="payment-methods">
                                <li>Cash</li>
                                <li>Credit/Debit Cards</li>
                                <li>Venmo</li>
                                <li>Apple Pay</li>
                            </ul>
                        </div>
                        <button type="submit" class="submit-order">Place Order</button>
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
    <script src="js/app.js"></script>
    <script src="js/order-form.js"></script>
</body>
</html> 