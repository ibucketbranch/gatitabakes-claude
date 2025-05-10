<?php
$page_title = 'Order Bread – Gatita Bakes';
$additional_head = '<link rel="stylesheet" href="css/order-form-new.css?v=' . time() . '">';
require_once 'includes/header.php';
?>

<main>
    <div class="order-form-container">
        <div class="order-form-inner">
            <h1 class="order-title">Order Your Sourdough Experience</h1>
            
            <!-- Product Grid -->
            <div class="product-grid">
                <?php foreach ($PRODUCTS as $id => $product): ?>
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="<?php echo IMAGES_PATH . '/' . $product['image']; ?>" 
                             alt="<?php echo $product['name']; ?>">
                    </div>
                    <h3><?php echo $product['name']; ?></h3>
                    <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                    <button class="add-to-cart" data-id="<?php echo $id; ?>" data-price="<?php echo $product['price']; ?>">Add to Cart</button>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Order Form -->
            <div class="order-form-wrapper">
                <form id="order-form" class="order-form">
                    <!-- Step 1: Order Type -->
                    <div class="form-section step" id="step-1">
                        <h2>How would you like to get your order?</h2>
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
                            <div id="pickup-location-fields" style="display: none;">
                                <h2>Pickup Location</h2>
                                <div class="form-group">
                                    <label for="pickup-location">Select Location</label>
                                    <select id="pickup-location" name="pickup-location" required>
                                        <option value="">Select a pickup location</option>
                                        <option value="westsac">West Sacramento (Near I St. Bridge)</option>
                                        <option value="farmersmarket">Sac Farmers Market</option>
                                    </select>
                                </div>
                            </div>
                            <div id="delivery-address-fields" style="display: none;">
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
                    <!-- Navigation Buttons -->
                    <div class="form-nav-row">
                        <button type="button" class="back-btn form-nav-btn" id="back-btn" style="display:none;">
                            <span class="arrow">&#8592;</span> Back
                        </button>
                        <button type="button" class="next-btn form-nav-btn" id="next-btn">
                            Next <span class="arrow">&#8594;</span>
                        </button>
                    </div>
                </form>
                <!-- Cart Summary -->
                <div class="cart-summary">
                    <h2>Order Summary</h2>
                    <div id="sidebar-cart-summary">
                        <div class="sidebar-cart-items"></div>
                        <div class="sidebar-cart-total">Total: $0.00</div>
                    </div>
                    <button type="button" class="place-order-btn" onclick="submitOrder()">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="js/order-form.js?v=<?php echo time(); ?>"></script>
<?php require_once 'includes/footer.php'; ?> 