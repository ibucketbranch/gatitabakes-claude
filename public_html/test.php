<?php
$page_title = 'Order Form Test';
$additional_head = '<style>
    /* Updated layout styles */
    body {
        font-family: Arial, sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background: #f9f9f9;
    }

    .main-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-top: 30px;
    }

    .order-section {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .cart-summary {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        position: sticky;
        top: 20px;
        height: fit-content;
        margin-bottom: 0;
    }

    .cart-summary h2 {
        margin-top: 0;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .cart-items {
        width: 100%;
        margin-bottom: 10px;
    }

    .cart-total {
        padding-top: 15px;
        border-top: 2px solid #f0f0f0;
        font-weight: bold;
        font-size: 1.2em;
    }

    .order-form {
        background: transparent;
        box-shadow: none;
        padding: 0;
    }

    .form-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .form-section h2 {
        margin-top: 0;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .order-type-section {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .order-type-option {
        flex: 1;
        padding: 20px;
        border: 2px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .order-type-option.active {
        border-color: #8b4513;
        background: #fff5e6;
    }

    .submit-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        text-align: center;
    }

    button[type="submit"] {
        background: #8b4513;
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 8px;
        font-size: 1.1em;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background: #6d3610;
    }

    .payment-info {
        margin-top: 15px;
        color: #666;
        font-size: 0.9em;
    }

    /* Basic styling for testing */
    .carousel-container {
        position: relative;
        margin-bottom: 30px;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }
    .product-card {
        border: 1px solid #ddd;
        padding: 12px;
        border-radius: 8px;
        background: white;
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 320px; /* Reduced from 380px */
    }
    .product-card img {
        width: 100%;
        height: 180px; /* Reduced from 200px */
        object-fit: cover;
        border-radius: 4px;
        background-color: #f5f5f5;
        margin-bottom: 10px; /* Reduced from 15px */
    }
    .product-card h3 {
        margin: 8px 0;
        font-size: 1.1em;
        flex-grow: 0;
    }
    .product-card p {
        margin: 4px 0 12px;
        font-size: 1em;
        font-weight: bold;
        color: #8b4513;
        flex-grow: 0;
    }
    .product-card .add-to-cart {
        margin-top: auto; /* Push button to bottom */
    }
    .placeholder-img {
        width: 100%;
        height: 180px; /* Reduced from 200px to match img */
        background: linear-gradient(135deg, #e6e6e6 0%, #f5f5f5 100%);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 14px;
        margin-bottom: 10px; /* Reduced from 15px */
    }
    .carousel-nav {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        gap: 10px;
    }
    .carousel-dots {
        display: flex;
        gap: 8px;
    }
    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ddd;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .dot.active {
        background: #8b4513;
    }
    .carousel-arrow {
        background: #8b4513;
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .carousel-arrow:disabled {
        background: #ddd;
        cursor: not-allowed;
    }
    .product-slide {
        display: none;
    }
    .product-slide.active {
        display: grid;
    }
    .add-to-cart {
        width: 100%;
        padding: 10px;
        background: #8b4513;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .quantity-input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 4px;
        font-size: 14px;
        width: 50px;
        text-align: center;
        margin: 0 5px;
    }

    .quantity-input:focus {
        outline: none;
        border-color: #8b4513;
    }

    /* Hide number input spinners */
    .quantity-input::-webkit-inner-spin-button,
    .quantity-input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .quantity-input[type=number] {
        -moz-appearance: textfield;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 1fr 90px 80px 32px;
        align-items: center;
        gap: 8px;
        padding: 6px 0;
        border-bottom: 1px solid #eee;
    }

    .item-name {
        text-align: left;
        font-size: 1em;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .item-quantity {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2px;
    }

    .quantity-btn {
        width: 22px;
        height: 22px;
        padding: 0;
        background: #8b4513;
        color: #fff;
        border: none;
        border-radius: 3px;
        font-size: 1em;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
    }

    .quantity-btn:hover {
        background: #6d3610;
    }

    .quantity-input {
        width: 32px;
        height: 22px;
        padding: 0 2px;
        font-size: 1em;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin: 0 2px;
    }

    .item-price {
        text-align: right;
        font-weight: 500;
        font-size: 1em;
        color: #8b4513;
    }

    .remove-item {
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        font-size: 1.1em;
        padding: 0;
        margin-left: 2px;
        line-height: 1;
    }

    .zip-input-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .zip-loading {
        position: absolute;
        right: 10px;
        display: flex;
        align-items: center;
    }

    .spinner {
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #8b4513;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }

    .success-message {
        color: #28a745;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }

    input:read-only {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }

    input:read-only:focus {
        outline: none;
        box-shadow: none;
    }

    .cart-items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }
    .cart-items-table th, .cart-items-table td {
        padding: 6px 8px;
        text-align: center;
        border-bottom: 1px solid #eee;
        font-size: 1em;
    }
    .cart-items-table th.item-name,
    .cart-items-table td.item-name {
        text-align: left;
        width: 40%;
        font-weight: 500;
    }
    .cart-items-table th.item-qty,
    .cart-items-table td.item-qty {
        width: 110px;
    }
    .cart-items-table th.item-price,
    .cart-items-table td.item-price {
        width: 80px;
        text-align: right;
        color: #8b4513;
        font-weight: 500;
    }
    .cart-items-table th.item-remove,
    .cart-items-table td.item-remove {
        width: 32px;
        text-align: center;
    }
    .qty-controls {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2px;
    }
    .qty-link {
        display: inline-block;
        color: #8b4513;
        font-size: 1.1em;
        font-weight: bold;
        width: 18px;
        height: 18px;
        line-height: 18px;
        text-align: center;
        cursor: pointer;
        user-select: none;
        background: none;
        border: none;
        padding: 0;
        margin: 0;
        transition: color 0.2s;
    }
    .qty-link:hover {
        color: #6d3610;
        text-decoration: underline;
    }
    .quantity-input {
        width: 32px;
        height: 20px;
        padding: 0 2px;
        font-size: 1em;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin: 0 2px;
    }
    .remove-item {
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        font-size: 1.1em;
        padding: 0;
        margin-left: 2px;
        line-height: 1;
    }
    .arrow-btn {
        background: #fff;
        border: 2px solid #8b4513;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2em;
        color: #8b4513;
        cursor: pointer;
        margin: 0 8px;
        transition: background 0.2s, color 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .arrow-btn:hover {
        background: #8b4513;
        color: #fff;
    }
    .arrow {
        display: inline-block;
        font-weight: bold;
    }
    .form-nav-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 32px;
        width: 100%;
    }
    .form-nav-btn {
        background: #f5f5f5;
        color: #333;
        border: 2px solid #ddd;
        border-radius: 8px;
        padding: 6px 16px;
        font-size: 0.95em;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        transition: background 0.2s, color 0.2s, border-color 0.2s;
        min-width: 80px;
        min-height: 32px;
    }
    .form-nav-btn:hover, .form-nav-btn:focus {
        background: #ececec;
        border-color: #8b4513;
        color: #8b4513;
    }
    .form-nav-btn .arrow {
        font-size: 1em;
        font-weight: bold;
    }
    .cart-total-and-submit {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 16px;
        justify-content: flex-end;
    }
    .place-order-btn {
        background: #8b4513;
        color: #fff;
        border: none;
        padding: 14px 36px;
        border-radius: 8px;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.2s;
    }
    .place-order-btn:hover {
        background: #6d3610;
    }
    .payment-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    
    .payment-modal-content {
        background-color: white;
        padding: 30px;
        border-radius: 12px;
        max-width: 500px;
        width: 90%;
        position: relative;
        text-align: center;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .close-modal {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 24px;
        cursor: pointer;
        color: #999;
    }
    
    .order-number, .order-total {
        font-weight: bold;
        margin: 5px 0;
    }
    
    .confirmation-message {
        color: #28a745;
        font-weight: bold;
        font-size: 1.1em;
        margin-bottom: 10px;
    }
    
    .confirmation-list {
        text-align: left;
        display: inline-block;
        margin: 10px auto;
    }
    
    .confirmation-list li {
        margin-bottom: 5px;
    }
    
    .order-confirmation {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin: 15px 0;
    }
    
    .payment-options {
        margin: 20px 0;
    }
    
    .payment-option {
        margin-bottom: 20px;
    }
    
    .payment-option h3 {
        color: #8b4513;
    }
    
    .qr-code {
        background-color: white;
        padding: 15px;
        display: inline-block;
        border: 1px solid #eee;
        border-radius: 5px;
        margin: 15px 0;
    }
    
    .qr-code img {
        max-width: 200px;
        height: auto;
    }
    
    .venmo-button {
        display: inline-block;
        background-color: #008CFF;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        margin: 10px 0;
    }
    
    .payment-instructions {
        margin: 20px 0;
        font-size: 0.9em;
        color: #666;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
    }
    
    .alternative-payment {
        margin-bottom: 8px;
        font-weight: bold;
    }
    
    .done-button {
        background-color: #8b4513;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-size: 1em;
        cursor: pointer;
        margin-top: 15px;
    }

    .thank-you-message {
        font-weight: bold;
        margin-top: 20px;
        font-size: 1.1em;
        color: #8b4513;
    }

    .confirmation-page {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 30px;
        background-color: #f9f9f9;
    }
    
    .confirmation-container {
        background-color: white;
        padding: 40px;
        border-radius: 12px;
        max-width: 600px;
        width: 100%;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .confirmation-container h2 {
        color: #8b4513;
        margin-bottom: 20px;
        font-size: 1.8em;
    }
    
    .order-number, .order-total {
        font-weight: bold;
        margin: 5px 0;
        font-size: 1.1em;
    }
    
    .order-confirmation {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin: 25px 0;
        text-align: center;
    }
    
    .confirmation-message {
        font-size: 1.1em;
        margin-bottom: 15px;
    }
    
    .payment-option {
        margin: 30px 0;
    }
    
    .payment-option h3 {
        color: #8b4513;
        margin-bottom: 15px;
    }
    
    .qr-code {
        background-color: white;
        padding: 15px;
        display: inline-block;
        border: 1px solid #eee;
        border-radius: 5px;
        margin: 15px 0;
    }
    
    .qr-code img {
        max-width: 200px;
        height: auto;
    }
    
    .venmo-button {
        display: inline-block;
        background-color: #008CFF;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        margin: 10px 0;
    }
    
    .venmo-button:hover {
        background-color: #0070cc;
    }
    
    .thank-you-message {
        font-weight: bold;
        margin-top: 20px;
        font-size: 1.2em;
        color: #8b4513;
    }
    
    .redirect-message {
        margin-top: 30px;
        color: #666;
        font-size: 0.9em;
    }
    
    .redirect-message span {
        font-weight: bold;
    }
    
    @media (max-width: 768px) {
        .confirmation-container {
            padding: 25px;
        }
    }

    .order-more {
        margin-top: 30px;
        text-align: center;
    }
    
    .order-more-btn {
        display: inline-block;
        background-color: #8b4513;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        font-size: 1.1em;
        transition: background-color 0.2s;
    }
    
    .order-more-btn:hover {
        background-color: #6d3610;
    }

    .shipping-info, .catering-info {
        background: #fdfaf7;
        border: 1px solid #e5a98c;
        border-radius: 6px;
        padding: 12px 18px;
        margin: 18px 0 0 0;
        color: #5a4e46;
        font-size: 1em;
        text-align: center;
    }
    .future-reference-box {
        background: #f5f5f5;
        border: 1px dashed #ccc;
        border-radius: 6px;
        padding: 12px 18px;
        margin: 24px 0;
        color: #666;
        font-size: 0.95em;
        text-align: center;
    }
    .future-reference-box p {
        margin: 0;
    }
    .future-reference-box strong {
        color: #8b4513;
    }
    .return-home-btn {
        display: inline-block;
        background-color: #e0e0e0;
        color: #333;
        padding: 12px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        font-size: 1.1em;
        margin-left: 12px;
        transition: background-color 0.2s;
    }
    .return-home-btn:hover {
        background-color: #bdbdbd;
    }
</style>';
require_once 'includes/header.php';
?>
    
<h1>Order Form Test</h1>

<div class="main-container">
    <form id="order-form" class="order-form">
        <!-- Step 1: Pickup or Delivery -->
        <div class="form-section step" id="step-1">
            <h2>How would you like to get your order?</h2>
            <div class="order-type-section">
                <label class="order-type-option">
                    <input type="radio" name="order_type" value="pickup" required> Pickup
                </label>
                <label class="order-type-option">
                    <input type="radio" name="order_type" value="delivery" required> Delivery
                </label>
            </div>
            <div class="form-nav-row">
                <button type="button" class="back-btn form-nav-btn left" aria-label="Back">
                    <span class="arrow">&#8592;</span> Back
                </button>
                <button type="button" class="next-btn form-nav-btn right" aria-label="Next">
                    Next <span class="arrow">&#8594;</span>
                </button>
            </div>
        </div>

        <!-- Step 2: Conditional Pickup/Delivery Form and Contact Info -->
        <div class="form-section step" id="step-2" style="display:none;">
            <div class="pickup-delivery-row" style="display: flex; gap: 32px;">
                <div id="pickup-location-fields" style="flex: 1; display: none;">
                    <h2>Pickup Location</h2>
                    <div class="form-group">
                        <label for="pickup-location">Select a pickup location</label>
                        <select id="pickup-location" name="pickup-location">
                            <option value="">Select a pickup location</option>
                            <option value="westsac">West Sacramento (Near I St. Bridge)</option>
                            <option value="farmersmarket">Sac Farmers Market</option>
                        </select>
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
                        <input type="text" 
                               id="delivery-zip" 
                               name="delivery-zip" 
                               pattern="[0-9]{5}" 
                               title="Five digit ZIP code" 
                               maxlength="5"
                               placeholder="Enter ZIP code">
                    </div>
                </div>
                <div class="contact-info-fields" style="flex: 1;">
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
            <div class="form-nav-row">
                <button type="button" class="back-btn form-nav-btn left" aria-label="Back">
                    <span class="arrow">&#8592;</span> Back
                </button>
                <button type="button" class="next-btn form-nav-btn right" aria-label="Next">
                    Next <span class="arrow">&#8594;</span>
                </button>
            </div>
        </div>

        <!-- Step 3: Product selection/cart -->
        <div class="form-section step" id="step-3" style="display:none;">
            <h2>Items in Cart</h2>
            <div class="cart-items"></div>
            <div id="empty-cart-message">Your cart is empty. Add some delicious bread!</div>
            <div class="form-nav-row">
                <button type="button" class="back-btn form-nav-btn left" aria-label="Back">
                    <span class="arrow">&#8592;</span> Back
                </button>
            </div>
            <div class="payment-info">
                Please pay using Venmo link in confirmation email - @katvalderrama
            </div>
        </div>
    </form>
    <!-- Sidebar Order Summary and Items in Cart remain on the right -->
    <div class="cart-summary">
        <h2>Order Summary</h2>
        <div id="sidebar-cart-summary">
            <div class="sidebar-cart-items"></div>
            <div class="sidebar-cart-total" style="font-weight: bold; margin-top: 12px;">Total: $0.00</div>
        </div>
        <div class="sidebar-place-order-row" style="margin-top: 24px; text-align: center;">
            <button type="button" onclick="submitOrder()" class="place-order-btn small">Place Order</button>
        </div>
    </div>
</div>

<!-- Product cards/carousel below the form -->
<div class="product-cards-below">
    <div class="carousel-container">
        <!-- First set of products -->
        <div class="product-slide active">
            <div class="product-grid">
                <?php foreach (array_slice($PRODUCTS, 0, 3) as $id => $product): ?>
                <div class="product-card">
                    <div class="placeholder-img"><?php echo $product['name']; ?></div>
                    <img src="<?php echo IMAGES_PATH . '/' . $product['image']; ?>" 
                         alt="<?php echo $product['name']; ?>"
                         onload="console.log('Image loaded successfully:', this.src); this.previousElementSibling.style.display='none';"
                         onerror="console.error('Failed to load image:', this.src); this.style.display='none'; this.previousElementSibling.style.display='flex';">
                    <h3><?php echo $product['name']; ?></h3>
                    <p>$<?php echo number_format($product['price'], 2); ?></p>
                    <button class="add-to-cart" data-id="<?php echo $id; ?>" data-price="<?php echo $product['price']; ?>">Add to Cart</button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Second set of products -->
        <div class="product-slide">
            <div class="product-grid">
                <?php foreach (array_slice($PRODUCTS, 3) as $id => $product): ?>
                <div class="product-card">
                    <div class="placeholder-img"><?php echo $product['name']; ?></div>
                    <img src="<?php echo IMAGES_PATH . '/' . $product['image']; ?>" 
                         alt="<?php echo $product['name']; ?>"
                         onload="console.log('Image loaded successfully:', this.src); this.previousElementSibling.style.display='none';"
                         onerror="console.error('Failed to load image:', this.src); this.style.display='none'; this.previousElementSibling.style.display='flex';">
                    <h3><?php echo $product['name']; ?></h3>
                    <p>$<?php echo number_format($product['price'], 2); ?></p>
                    <button class="add-to-cart" data-id="<?php echo $id; ?>" data-price="<?php echo $product['price']; ?>">Add to Cart</button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Carousel Navigation -->
        <div class="carousel-nav">
            <button class="carousel-arrow prev" onclick="prevSlide()">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="carousel-dots">
                <span class="dot active" onclick="showSlide(0)"></span>
                <span class="dot" onclick="showSlide(1)"></span>
            </div>
            <button class="carousel-arrow next" onclick="nextSlide()">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<script>
// Clear cart on every page load
localStorage.removeItem('cart');
let cart = [];

// Multi-step form navigation
const steps = document.querySelectorAll('.form-section');
let currentStep = 0;

function showStep(n) {
    console.log('Showing step:', n);
    // Validate step bounds
    if (n < 0) n = 0;
    if (n >= steps.length) n = steps.length - 1;
    
    // Hide all steps
    steps.forEach(step => {
        step.classList.remove('active');
        step.style.display = 'none';
    });
    
    // Show the current step
    if (steps[n]) {
        steps[n].style.display = 'block';
        steps[n].classList.add('active');
        currentStep = n;
        console.log('Current step set to:', currentStep);
    }
    
    // Show/hide delivery or pickup fields on step 2
    if (n === 1) {
        const orderTypeInput = document.querySelector('input[name="order_type"]:checked');
        const deliveryFields = document.getElementById('delivery-address-fields');
        const pickupFields = document.getElementById('pickup-location-fields');
        
        if (orderTypeInput && orderTypeInput.value === 'delivery') {
            if (deliveryFields) deliveryFields.style.display = 'block';
            if (pickupFields) pickupFields.style.display = 'none';
        } else if (orderTypeInput && orderTypeInput.value === 'pickup') {
            if (deliveryFields) deliveryFields.style.display = 'none';
            if (pickupFields) pickupFields.style.display = 'block';
        }
    }
    
    // Update navigation buttons
    updateNavigationButtons();
}

function updateNavigationButtons() {
    const backButtons = document.querySelectorAll('.back-btn');
    const nextButtons = document.querySelectorAll('.next-btn');
    
    console.log('Updating navigation buttons for step:', currentStep);
    
    // Hide back button on first step, show on others
    backButtons.forEach(btn => {
        btn.style.display = currentStep === 0 ? 'none' : 'flex';
    });
    
    // Update next buttons
    nextButtons.forEach(btn => {
        if (currentStep === steps.length - 1) {
            btn.innerHTML = 'Place Order';
            btn.classList.add('place-order-btn');
        } else {
            btn.innerHTML = 'Next <span class="arrow">&#8594;</span>';
            btn.classList.remove('place-order-btn');
        }
    });
}

function validateStep(step) {
    console.log('Validating step:', step);
    let orderType;
    switch(step) {
        case 0:
            orderType = document.querySelector('input[name="order_type"]:checked');
            if (!orderType) {
                alert('Please select Pickup or Delivery.');
                console.log('Step 0 validation failed: No order type selected');
                return false;
            }
            console.log('Step 0 validation passed');
            return true;
        case 1:
            // Validate contact info
            const requiredFields = ['first-name', 'last-name', 'email', 'phone'];
            for (const field of requiredFields) {
                if (!document.getElementById(field)?.value) {
                    alert('Please fill out all contact information fields.');
                    console.log('Step 1 validation failed:', field);
                    return false;
                }
            }
            // Validate delivery/pickup specific fields
            orderType = document.querySelector('input[name="order_type"]:checked')?.value;
            if (orderType === 'delivery') {
                const deliveryFields = ['delivery-address', 'delivery-city', 'delivery-state', 'delivery-zip'];
                for (const field of deliveryFields) {
                    if (!document.getElementById(field)?.value) {
                        alert('Please fill out all required delivery address fields.');
                        console.log('Step 1 validation failed:', field);
                        return false;
                    }
                }
            } else {
                if (!document.getElementById('pickup-location')?.value) {
                    alert('Please select a pickup location.');
                    console.log('Step 1 validation failed: No pickup location');
                    return false;
                }
            }
            console.log('Step 1 validation passed');
            return true;
        case 2:
            // Validate cart is not empty
            if (!cart.length) {
                alert('Please add at least one item to your cart.');
                console.log('Step 2 validation failed: Empty cart');
                return false;
            }
            console.log('Step 2 validation passed');
            return true;
        default:
            console.log('Default validation passed');
            return true;
    }
}

// Initialize navigation
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing form navigation');
    
    // Show first step
    showStep(0);
    
    // Add click handlers for navigation buttons
    document.querySelectorAll('.next-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            console.log('Next button clicked, current step:', currentStep);
            if (validateStep(currentStep)) {
                showStep(currentStep + 1);
            }
        });
    });
    
    document.querySelectorAll('.back-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            console.log('Back button clicked, current step:', currentStep);
            showStep(currentStep - 1);
        });
    });

    // Add event listeners to Pickup/Delivery radio buttons
    document.querySelectorAll('input[name="order_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const deliveryFields = document.getElementById('delivery-address-fields');
            const pickupFields = document.getElementById('pickup-location-fields');
            
            if (this.value === 'delivery') {
                if (deliveryFields) deliveryFields.style.display = 'block';
                if (pickupFields) pickupFields.style.display = 'none';
            } else {
                if (deliveryFields) deliveryFields.style.display = 'none';
                if (pickupFields) pickupFields.style.display = 'block';
            }
        });
    });

    // Add to Cart Button Listeners
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            const productPrice = parseFloat(this.dataset.price);
            const productName = this.closest('.product-card').querySelector('h3').textContent;
            addToCart(productId, productName, productPrice);
        });
    });

    // Initialize carousel
    initializeCarousel();
});

// Cart functions
function addToCart(productId, productName, price) {
    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: productId,
            name: productName,
            price: price,
            quantity: 1
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

function updateQuantity(productId, newQuantity) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        if (newQuantity <= 0) {
            removeFromCart(productId);
        } else {
            item.quantity = newQuantity;
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartDisplay();
        }
    }
}

function updateCartDisplay() {
    const cartItemsContainer = document.querySelector('.cart-items');
    const sidebarCartItems = document.querySelector('.sidebar-cart-items');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    const total = calculateCartTotal();

    // Update main cart display
    if (cartItemsContainer) {
        cartItemsContainer.innerHTML = '';
        if (cart.length === 0) {
            if (emptyCartMessage) emptyCartMessage.style.display = 'block';
        } else {
            if (emptyCartMessage) emptyCartMessage.style.display = 'none';
            const table = createCartTable();
            cartItemsContainer.appendChild(table);
        }
    }

    // Update sidebar cart
    if (sidebarCartItems) {
        sidebarCartItems.innerHTML = '';
        cart.forEach(item => {
            const itemRow = document.createElement('div');
            itemRow.className = 'cart-item';
            itemRow.innerHTML = `
                <div class="item-name">${item.name}</div>
                <div class="item-quantity">
                    <button class="quantity-btn" onclick="updateQuantity('${item.id}', ${item.quantity - 1})">-</button>
                    <input type="number" class="quantity-input" value="${item.quantity}" 
                           onchange="updateQuantity('${item.id}', parseInt(this.value) || 0)">
                    <button class="quantity-btn" onclick="updateQuantity('${item.id}', ${item.quantity + 1})">+</button>
                </div>
                <div class="item-price">$${(item.price * item.quantity).toFixed(2)}</div>
                <button class="remove-item" onclick="removeFromCart('${item.id}')">×</button>
            `;
            sidebarCartItems.appendChild(itemRow);
        });
    }

    // Update all total displays
    document.querySelectorAll('.cart-total, .sidebar-cart-total').forEach(el => {
        el.textContent = `Total: $${total.toFixed(2)}`;
    });
}

function createCartTable() {
    const table = document.createElement('table');
    table.className = 'cart-items-table';
    table.innerHTML = `
        <thead>
            <tr>
                <th class="item-name">Item</th>
                <th class="item-qty">Qty</th>
                <th class="item-price">Price</th>
                <th class="item-remove"></th>
            </tr>
        </thead>
        <tbody></tbody>
    `;
    
    const tbody = table.querySelector('tbody');
    cart.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="item-name">${item.name}</td>
            <td class="item-qty">
                <div class="qty-controls">
                    <button class="qty-link" onclick="updateQuantity('${item.id}', ${item.quantity - 1})">−</button>
                    <input type="number" min="0" value="${item.quantity}" 
                           onchange="updateQuantity('${item.id}', parseInt(this.value) || 0)" 
                           class="quantity-input">
                    <button class="qty-link" onclick="updateQuantity('${item.id}', ${item.quantity + 1})">+</button>
                </div>
            </td>
            <td class="item-price">$${(item.price * item.quantity).toFixed(2)}</td>
            <td class="item-remove"><button class="remove-item" onclick="removeFromCart('${item.id}')">×</button></td>
        `;
        tbody.appendChild(row);
    });
    
    return table;
}

function calculateCartTotal() {
    return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
}

// Carousel functions
function initializeCarousel() {
    window.currentSlide = 0;
    window.slides = document.querySelectorAll('.product-slide');
    window.dots = document.querySelectorAll('.dot');
    
    updateSlide(0);
    
    // Add event listeners for carousel navigation
    document.querySelector('.prev').addEventListener('click', () => prevSlide());
    document.querySelector('.next').addEventListener('click', () => nextSlide());
    document.querySelectorAll('.dot').forEach((dot, index) => {
        dot.addEventListener('click', () => showSlide(index));
    });
}

function updateSlide(index) {
    window.slides.forEach(slide => slide.classList.remove('active'));
    window.dots.forEach(dot => dot.classList.remove('active'));
    window.slides[index].classList.add('active');
    window.dots[index].classList.add('active');
    window.currentSlide = index;
}

function showSlide(n) {
    if (n < 0) n = 0;
    if (n >= window.slides.length) n = window.slides.length - 1;
    updateSlide(n);
}

function nextSlide() {
    if (window.currentSlide < window.slides.length - 1) {
        updateSlide(window.currentSlide + 1);
    }
}

function prevSlide() {
    if (window.currentSlide > 0) {
        updateSlide(window.currentSlide - 1);
    }
}

function generateOrderNumber() {
    // Get current year's last two digits
    const year = new Date().getFullYear().toString().slice(-2);
    
    // Get or initialize the counter for this year from localStorage
    let yearKey = `orderCounter${year}`;
    let counter = localStorage.getItem(yearKey);
    
    // If it's a new year or no counter exists, start from 1
    if (!counter) {
        counter = 1;
    } else {
        counter = parseInt(counter) + 1;
        
        // If we reach 9999, show a warning
        if (counter > 9999) {
            console.warn('Order number counter has exceeded maximum value for the year');
            // Reset to 1 to prevent issues
            counter = 1;
        }
    }
    
    // Store the new counter
    localStorage.setItem(yearKey, counter);
    
    // Format the counter to have leading zeros (4 digits)
    const paddedCounter = counter.toString().padStart(4, '0');
    
    // Return the formatted order number (e.g., GB-250001)
    return `GB-${year}${paddedCounter}`;
}

function submitOrder() {
    // Generate structured order number
    const orderNumber = generateOrderNumber();
    const orderTotal = calculateCartTotal();
    
    // Get form data
    const form = document.getElementById('order-form');
    const orderType = document.querySelector('input[name="order_type"]:checked').value;
    
    // Create order data object
    const orderData = {
        orderNumber: orderNumber,
        orderType: orderType,
        total: orderTotal,
        items: cart,
        customer: {
            firstName: document.getElementById('first-name').value,
            lastName: document.getElementById('last-name').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value
        }
    };
    
    // Add delivery or pickup-specific info
    if (orderType === 'delivery') {
        orderData.deliveryAddress = {
            street: document.getElementById('delivery-address').value,
            unit: document.getElementById('delivery-unit').value || '',
            city: document.getElementById('delivery-city').value,
            state: document.getElementById('delivery-state').value,
            zip: document.getElementById('delivery-zip').value
        };
        orderData.notes = document.querySelector('textarea[name="delivery-notes"]')?.value || '';
    } else {
        orderData.pickupLocation = document.getElementById('pickup-location').value;
        orderData.notes = document.querySelector('textarea[name="pickup-notes"]')?.value || '';
    }
    
    // Send to server
    fetch('includes/process-order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderData)
    })
    .then(response => response.json())
    .then(result => {
        console.log('Order processed:', result);
        // Show confirmation page regardless of email success
        showConfirmationPage(orderNumber, orderTotal, result.success, orderType, orderData.pickupLocation);
    })
    .catch(error => {
        console.error('Error processing order:', error);
        // Still show confirmation page even if server request failed
        showConfirmationPage(orderNumber, orderTotal, false, orderType, orderData.pickupLocation);
    });
    
    // Reset form and cart for when they return
    cart = [];
    localStorage.removeItem('cart');
}

function showConfirmationPage(orderNumber, orderTotal, emailSent, orderType, pickupLocation) {
    // Get user name and email
    const firstName = document.getElementById('first-name')?.value || '';
    const lastName = document.getElementById('last-name')?.value || '';
    const email = document.getElementById('email')?.value || '';
    let pickupDetails = '';
    let deliveryDetails = '';
    if (orderType === 'pickup') {
        if (pickupLocation === 'westsac') {
            pickupDetails = `
                <div class="pickup-info">
                    <p><strong>Pickup Address:</strong><br>291 McDowell Lane<br>West Sacramento, CA 95605</p>
                    <div class="map-container">
                        <iframe
                            width="100%"
                            height="250"
                            frameborder="0"
                            style="border:0"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3119.0447824971387!2d-121.53357548439393!3d38.58931927961859!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x809ada9b8531c8e5%3A0x68a8655772f2e40a!2s291%20McDowell%20Ln%2C%20West%20Sacramento%2C%20CA%2095605!5e0!3m2!1sen!2sus!4v1683489632669!5m2!1sen!2sus"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            `;
        } else if (pickupLocation === 'farmersmarket') {
            pickupDetails = `<div class="pickup-info"><p><strong>Pickup Location:</strong> Sac Farmers Market</p><p>Katerina will provide specific market location and time details when confirming your order.</p></div>`;
        }
    } else if (orderType === 'delivery') {
        // Build delivery address string
        const street = document.getElementById('delivery-address')?.value || '';
        const unit = document.getElementById('delivery-unit')?.value || '';
        const city = document.getElementById('delivery-city')?.value || '';
        const state = document.getElementById('delivery-state')?.value || '';
        const zip = document.getElementById('delivery-zip')?.value || '';
        let address = street;
        if (unit) address += ', ' + unit;
        address += ', ' + city + ', ' + state + ' ' + zip;
        deliveryDetails = `<div class="delivery-info"><p><strong>Delivery to:</strong> ${address}</p><p>Delivery to <strong>${address}</strong> will be confirmed with order ready date by email or text in 24 hours.</p></div>`;
    }
    const confirmationHTML = `
        <div class="confirmation-page">
            <div class="confirmation-container">
                <h2>Thank You for Your Order!</h2>
                <p class="order-number">Order #${orderNumber}</p>
                <p class="order-total">Total: $${orderTotal.toFixed(2)}</p>
                <p class="confirmation-message">${firstName ? `${firstName}, thank you for your order!` : 'Thank you for your order!'}</p>
                ${pickupDetails}
                ${deliveryDetails}
                <div class="order-confirmation">
                    <p class="confirmation-message">Katerina will confirm receipt of payment and order ready date.</p>
                    <p>You can pay directly to <strong>@katvalderrama</strong> via Venmo.</p>
                    <p>Please include your order number <strong>#${orderNumber}</strong> in the notes.</p>
                </div>
                <div class="info-box catering-info">
                    <strong>Available for large dinners and catering.</strong>
                </div>
                ${emailSent && email ? `
                <div class="email-confirmation">
                    <p>A confirmation email has been sent to <strong>${email}</strong>.</p>
                    <p>Please check your inbox for details.</p>
                </div>
                ` : `
                <div class="email-error">
                    <p>We couldn't send a confirmation email at this time.</p>
                    <p>Please save your order number for reference.</p>
                </div>
                `}
                <div class="payment-options">
                    <div class="payment-option">
                        <h3>Pay with Venmo</h3>
                        <p>Scan this QR code with your phone:</p>
                        <div class="qr-code">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(generateVenmoLink(orderNumber, orderTotal))}" alt="Venmo Payment QR Code">
                        </div>
                        <p>Or click the button below:</p>
                        <a href="${generateVenmoLink(orderNumber, orderTotal)}" class="venmo-button" target="_blank">Open Venmo App</a>
                    </div>
                </div>
                <p class="thank-you-message">Thanks again!</p>
                <div class="future-reference-box shipping-info">
                    <p><strong>For future orders:</strong> Did you know we can sometimes arrange shipping within California? Feel free to ask about shipping options for your next order! (ツ)</p>
                </div>
                <div class="order-more">
                    <a href="javascript:location.reload()" class="order-more-btn">Order More! 😊</a>
                    <a href="/" class="return-home-btn">Return Home</a>
                </div>
            </div>
        </div>
    `;
    
    // Replace the entire page content with confirmation
    document.body.innerHTML = confirmationHTML;

    // Add styles for .shipping-info, .catering-info, and .return-home-btn
    const style = document.createElement('style');
    style.textContent += `
        .shipping-info, .catering-info {
            background: #fdfaf7;
            border: 1px solid #e5a98c;
            border-radius: 6px;
            padding: 12px 18px;
            margin: 18px 0 0 0;
            color: #5a4e46;
            font-size: 1em;
            text-align: center;
        }
        .future-reference-box {
            background: #f5f5f5;
            border: 1px dashed #ccc;
            border-radius: 6px;
            padding: 12px 18px;
            margin: 24px 0;
            color: #666;
            font-size: 0.95em;
            text-align: center;
        }
        .future-reference-box p {
            margin: 0;
        }
        .future-reference-box strong {
            color: #8b4513;
        }
        .return-home-btn {
            display: inline-block;
            background-color: #e0e0e0;
            color: #333;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1em;
            margin-left: 12px;
            transition: background-color 0.2s;
        }
        .return-home-btn:hover {
            background-color: #bdbdbd;
        }
    `;
    document.head.appendChild(style);
}

function generateVenmoLink(orderNumber, amount) {
    const venmoUsername = 'katvalderrama';
    const note = `Gatita Bakes Order #${orderNumber}`;
    
    // Mobile deep link (opens Venmo app if installed)
    if (/Android|iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        return `venmo://paycharge?txn=pay&recipients=${venmoUsername}&amount=${amount}&note=${encodeURIComponent(note)}`;
    }
    
    // Web link for desktop users
    return `https://venmo.com/${venmoUsername}?txn=pay&amount=${amount}&note=${encodeURIComponent(note)}`;
}
</script>