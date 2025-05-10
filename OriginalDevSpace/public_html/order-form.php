/**
 * Project: Gatita Bakes Online Order System
 * Title: Order Form
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2025-09-05
 */

<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>

<div class="order-form-container">
    <h1 class="order-title">Artisan Bread Selection</h1>
    
    <div class="progress-steps">
        <div class="progress-dot active"></div>
        <div class="progress-dot"></div>
        <div class="progress-dot"></div>
    </div>

    <div class="order-form-wrapper">
        <div class="main-content">
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                <div class="product-card" data-product-id="<?php echo htmlspecialchars($product['id']); ?>">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="product-info">
                        <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="form-section">
                <h2>Delivery Details</h2>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="delivery-method">Delivery Method</label>
                    <select id="delivery-method" name="delivery-method" required>
                        <option value="pickup">Store Pickup</option>
                        <option value="delivery">Home Delivery</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="cart-summary">
            <h2>Your Selection</h2>
            <div class="sidebar-cart-items">
                <!-- Cart items will be dynamically populated here -->
            </div>
            <div class="cart-total">
                <span>Total:</span>
                <span class="total-amount">$0.00</span>
            </div>
            <button class="place-order-btn">Place Order</button>
        </div>
    </div>
</div>

<script src="js/order-form.js"></script>

<?php require_once 'includes/footer.php'; ?>