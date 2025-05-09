<?php
// Include required files
require_once 'includes/config.php';
require_once 'includes/functions.php';
$page_title = 'Welcome';
require_once 'includes/header.php';
?>

<main>
    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h2>Artisan Delights</h2>
            <p>An Artisan Sourdough Company owned and operated by women.</p>
            <a href="order-form.php" class="cta-button">Order Now</a>
        </div>
    </section>

    <!-- Order Form Section -->
    <section id="order" class="order-section">
        <div class="order-container">
            <!-- Product Cards -->
            <div class="products-grid">
                <div class="product-card">
                    <img src="images/plain-sourdough.jpg" alt="Plain Sourdough">
                    <h3>Plain Sourdough</h3>
                    <p class="price">$8.00</p>
                    <button class="add-to-cart" data-id="plain-sourdough" data-price="8.00">Add to Cart</button>
                </div>
                <div class="product-card">
                    <img src="images/everything-sourdough.jpg" alt="Everything Sourdough">
                    <h3>Everything Sourdough</h3>
                    <p class="price">$9.00</p>
                    <button class="add-to-cart" data-id="everything-sourdough" data-price="9.00">Add to Cart</button>
                </div>
                <div class="product-card">
                    <img src="images/rosemary-sourdough.jpg" alt="Rosemary Sourdough">
                    <h3>Rosemary Sourdough</h3>
                    <p class="price">$9.00</p>
                    <button class="add-to-cart" data-id="rosemary-sourdough" data-price="9.00">Add to Cart</button>
                </div>
                <div class="product-card">
                    <img src="images/plain-bagels.jpg" alt="Plain Bagels">
                    <h3>Plain Bagels</h3>
                    <p class="price">$3.00</p>
                    <button class="add-to-cart" data-id="plain-bagels" data-price="3.00">Add to Cart</button>
                </div>
                <div class="product-card">
                    <img src="images/jalapeno-cheese-bagels.jpg" alt="Jalapeño Cheese Bagels">
                    <h3>Jalapeño Cheese Bagels</h3>
                    <p class="price">$3.50</p>
                    <button class="add-to-cart" data-id="jalapeno-cheese-bagels" data-price="3.50">Add to Cart</button>
                </div>
            </div>

            <!-- Order Form -->
            <form id="order-form" class="order-form">
                <!-- Step 1: Order Type -->
                <div class="form-section step" id="step-1">
                    <h2>Order Type</h2>
                    <div class="order-type-options">
                        <div class="order-type-option">
                            <input type="radio" id="pickup" name="order_type" value="pickup">
                            <label for="pickup">Pickup</label>
                        </div>
                        <div class="order-type-option">
                            <input type="radio" id="delivery" name="order_type" value="delivery">
                            <label for="delivery">Delivery</label>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Contact & Location Info -->
                <div class="form-section step" id="step-2" style="display:none;">
                    <div class="form-columns">
                        <div id="pickup-location-fields" style="flex: 1; display: none;">
                            <h2>Pickup Location</h2>
                            <div class="form-group">
                                <label for="pickup-location">Select Location</label>
                                <select id="pickup-location" name="pickup-location" required>
                                    <option value="">Select a pickup location</option>
                                    <option value="san-francisco">San Francisco</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pickup-notes">Special Instructions (Optional)</label>
                                <textarea id="pickup-notes" name="pickup-notes"></textarea>
                            </div>
                        </div>

                        <div id="delivery-address-fields" style="flex: 1; display: none;">
                            <h2>Delivery Address</h2>
                            <div class="form-group">
                                <label for="delivery-address">Street Address <span class="required">*</span></label>
                                <input type="text" id="delivery-address" name="delivery-address">
                            </div>
                            <div class="form-group">
                                <label for="delivery-unit">Apt/Suite/Unit</label>
                                <input type="text" id="delivery-unit" name="delivery-unit">
                            </div>
                            <div class="form-group">
                                <label for="delivery-city">City <span class="required">*</span></label>
                                <input type="text" id="delivery-city" name="delivery-city">
                            </div>
                            <div class="form-group">
                                <label for="delivery-state">State</label>
                                <input type="text" id="delivery-state" name="delivery-state" value="CA" readonly>
                            </div>
                            <div class="form-group">
                                <label for="delivery-zip">ZIP Code <span class="required">*</span></label>
                                <input type="text" id="delivery-zip" name="delivery-zip" pattern="[0-9]{5}" title="Five digit ZIP code">
                            </div>
                        </div>

                        <div class="contact-info">
                            <h2>Contact Information</h2>
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
                                <label for="phone">Phone</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Cart -->
                <div class="form-section step" id="step-3" style="display:none;">
                    <h2>Your Order</h2>
                    <div class="cart-items"></div>
                    <div id="empty-cart-message">Your cart is empty. Add some delicious bread!</div>
                    <div class="cart-total">Total: $<span id="cart-total">0.00</span></div>
                    <div class="payment-info">
                        <p>Please pay using Venmo to @katvalderrama</p>
                        <p>Include your order number in the payment notes.</p>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="form-nav-row">
                    <button type="button" class="back-btn form-nav-btn" style="display:none;">
                        <span class="arrow">←</span> Back
                    </button>
                    <button type="button" class="next-btn form-nav-btn">
                        Next <span class="arrow">→</span>
                    </button>
                </div>
            </form>

            <!-- Cart Summary Sidebar -->
            <div class="cart-summary">
                <h2>Order Summary</h2>
                <div id="sidebar-cart-summary">
                    <div class="sidebar-cart-items"></div>
                    <div class="sidebar-cart-total">Total: $0.00</div>
                </div>
                <button type="button" class="place-order-btn" onclick="submitOrder()">Place Order</button>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section id="our-story" class="our-story-section">
        <h2>Our Story</h2>
        <p>Bla bla bla... Gatita Bakes is a labor of love, passion, and tradition. Our journey began with a simple desire to share the joy of artisan sourdough with our community. (More story content coming soon!)</p>
        <p>Bla bla bla... We believe in quality, authenticity, and the power of women-owned businesses. Thank you for being part of our story.</p>
    </section>

    <!-- Contact Section -->
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

<?php require_once 'includes/footer.php'; ?> 