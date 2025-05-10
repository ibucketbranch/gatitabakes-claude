/**
 * Project: Gatita Bakes Online Order System
 * Title: Order Form
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250510.2
 * Date: 2025-05-10
 */
<?php
$page_title = 'Order Bread – Gatita Bakes';
$additional_head = '<link rel="stylesheet" href="css/order-form.css?v=' . time() . '">';
require_once 'includes/header.php';
?>

<main>
    <div class="order-form-container">
        <h1 class="order-title">Place Your Order</h1>
        
        <div class="order-form-wrapper">
            <form id="order-form" class="order-form">
                <!-- Contact Information Section -->
                <div class="form-section">
                    <h2>Contact Information</h2>
                    <div class="form-group">
                        <label for="full-name">Full Name</label>
                        <input type="text" id="full-name" name="full-name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Mobile Phone</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                </div>

                <!-- Order Type Section -->
                <div class="form-section">
                    <h2>Order Type</h2>
                    <div class="order-type-options">
                        <div class="order-type-option">
                            <input type="radio" id="pickup" name="order_type" value="pickup" checked>
                            <label for="pickup">Pickup</label>
                        </div>
                        <div class="order-type-option">
                            <input type="radio" id="delivery" name="order_type" value="delivery">
                            <label for="delivery">Delivery</label>
                        </div>
                    </div>
                    
                    <!-- Pickup Location Fields -->
                    <div id="pickup-location-fields">
                        <div class="form-group">
                            <label for="pickup-location">Choose Pickup Location</label>
                            <select id="pickup-location" name="pickup-location" required>
                                <option value="">Select pickup location</option>
                                <option value="westsac">West Sacramento (Near I St. Bridge)</option>
                                <option value="farmersmarket">Sac Farmers Market</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pickup-time">Pickup Time (10-15 Min Window)</label>
                            <select id="pickup-time" name="pickup-time" required>
                                <option value="">Select pickup time</option>
                                <option value="9:00">9:00 AM - 9:15 AM</option>
                                <option value="9:15">9:15 AM - 9:30 AM</option>
                                <option value="9:30">9:30 AM - 9:45 AM</option>
                                <option value="9:45">9:45 AM - 10:00 AM</option>
                                <option value="10:00">10:00 AM - 10:15 AM</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Delivery Address Fields -->
                    <div id="delivery-address-fields" style="display: none;">
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
                            <input type="text" id="delivery-city" name="delivery-city" value="Sacramento" readonly>
                        </div>
                        <div class="form-group">
                            <label for="delivery-zip">ZIP Code <span class="required">*</span></label>
                            <input type="text" id="delivery-zip" name="delivery-zip" pattern="[0-9]{5}" title="Five digit ZIP code">
                        </div>
                        <div class="form-group">
                            <label for="delivery-notes">Delivery Notes (Optional)</label>
                            <textarea id="delivery-notes" name="delivery-notes" rows="3" placeholder="Special instructions for delivery"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Information Section -->
                <div class="form-section">
                    <h2>Payment Information</h2>
                    <p class="payment-note">We accept payment on pickup via Venmo, CashApp, cash, or credit card.</p>
                    <div class="form-group">
                        <label for="payment-method">Preferred Payment Method</label>
                        <select id="payment-method" name="payment-method" required>
                            <option value="">Select payment method</option>
                            <option value="venmo">Venmo</option>
                            <option value="cashapp">CashApp</option>
                            <option value="cash">Cash</option>
                            <option value="card">Credit Card (in person)</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-nav-row">
                    <button type="submit" class="place-order-btn">Place Order</button>
                </div>
            </form>
            
            <!-- Order Summary -->
            <div class="cart-summary">
                <h2>Order Summary</h2>
                <div id="sidebar-cart-items">
                    <div class="cart-item">
                        <div class="item-details">
                            <span class="item-name">Plain Sourdough</span>
                            <span class="item-quantity">× 2</span>
                            <span class="item-price">$16.00</span>
                        </div>
                        <button class="remove-item" data-id="plain-sourdough">×</button>
                    </div>
                    <div class="cart-item">
                        <div class="item-details">
                            <span class="item-name">Everything Sourdough</span>
                            <span class="item-quantity">× 1</span>
                            <span class="item-price">$9.00</span>
                        </div>
                        <button class="remove-item" data-id="everything-sourdough">×</button>
                    </div>
                </div>
                <div class="sidebar-cart-total">
                    <span>Total:</span>
                    <span id="cart-total">$25.00</span>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="js/order-form.js?v=<?php echo time(); ?>"></script>
<?php require_once 'includes/footer.php'; ?>