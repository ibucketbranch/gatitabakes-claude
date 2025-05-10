<?php
/**
 * Project: Gatita Bakes Online Order System
 * Title: Test2
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2025-05-10
 */
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>
<main>
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
                <div class="cart-total-and-submit">
                    <button type="button" onclick="submitOrder()" class="place-order-btn">Place Order</button>
                </div>
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
const steps = document.querySelectorAll('.step');
let currentStep = 0;

function showStep(n) {
    // Hide all steps
    steps.forEach(step => step.style.display = 'none');
    
    // Show the current step
    if (steps[n]) {
        steps[n].style.display = 'block';
        currentStep = n;
    }
    
    // Show/hide delivery or pickup fields on step 2
    if (n === 1) {
        const orderTypeInput = document.querySelector('input[name="order_type"]:checked');
        const deliveryFields = document.getElementById('delivery-address-fields');
        const pickupFields = document.getElementById('pickup-location-fields');
        if (orderTypeInput && orderTypeInput.value === 'delivery') {
            if (deliveryFields) deliveryFields.style.display = '';
            if (pickupFields) pickupFields.style.display = 'none';
        } else {
            if (deliveryFields) deliveryFields.style.display = 'none';
            if (pickupFields) pickupFields.style.display = '';
        }
    }
    
    // Update navigation buttons
    updateNavigationButtons();
}

function updateNavigationButtons() {
    const backButtons = document.querySelectorAll('.back-btn');
    const nextButtons = document.querySelectorAll('.next-btn');
    
    // Update back buttons
    backButtons.forEach(btn => {
        btn.style.display = currentStep === 0 ? 'none' : 'block';
    });
    
    // Update next buttons
    nextButtons.forEach(btn => {
        if (currentStep === steps.length - 1) {
            btn.textContent = 'Place Order';
            btn.classList.add('place-order-btn');
        } else {
            btn.textContent = 'Next';
            btn.classList.remove('place-order-btn');
        }
    });
}

function validateStep(step) {
    let orderType;
    switch(step) {
        case 0:
            orderType = document.querySelector('input[name="order_type"]:checked');
            if (!orderType) {
                alert('Please select Pickup or Delivery.');
                return false;
            }
            return true;
        case 1:
            // Validate contact info
            const requiredFields = ['first-name', 'last-name', 'email', 'phone'];
            for (const field of requiredFields) {
                if (!document.getElementById(field).value) {
                    alert('Please fill out all contact information fields.');
                    return false;
                }
            }
            // Validate delivery/pickup specific fields
            orderType = document.querySelector('input[name="order_type"]:checked').value;
            if (orderType === 'delivery') {
                const deliveryFields = ['delivery-address', 'delivery-city', 'delivery-state', 'delivery-zip'];
                for (const field of deliveryFields) {
                    if (!document.getElementById(field).value) {
                        alert('Please fill out all required delivery address fields.');
                        return false;
                    }
                }
            } else {
                if (!document.getElementById('pickup-location').value) {
                    alert('Please select a pickup location.');
                    return false;
                }
            }
            return true;
        case 2:
            // Validate cart is not empty
            if (cart.length === 0) {
                alert('Please add at least one item to your cart.');
                return false;
            }
            return true;
        default:
            return true;
    }
}

// Initialize navigation
document.addEventListener('DOMContentLoaded', function() {
    // Show first step
    showStep(0);
    
    // Add click handlers for navigation buttons
    document.querySelectorAll('.next-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                if (currentStep === steps.length - 1) {
                    // Handle order submission
                    submitOrder();
                } else {
                    showStep(currentStep + 1);
                }
            }
        });
    });
    
    document.querySelectorAll('.back-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            showStep(currentStep - 1);
        });
    });

    // Add event listeners to Pickup/Delivery radio buttons to update fields in real time
    document.querySelectorAll('input[name="order_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Only update if on step 2
            if (currentStep === 1) {
                const deliveryFields = document.getElementById('delivery-address-fields');
                const pickupFields = document.getElementById('pickup-location-fields');
                if (this.value === 'delivery') {
                    if (deliveryFields) deliveryFields.style.display = '';
                    if (pickupFields) pickupFields.style.display = 'none';
                } else {
                    if (deliveryFields) deliveryFields.style.display = 'none';
                    if (pickupFields) pickupFields.style.display = '';
                }
            }
        });
    });

    // --- Add to Cart Button Listeners ---
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            const productPrice = parseFloat(this.dataset.price);
            const productName = this.closest('.product-card').querySelector('h3').textContent;
            addToCart(productId, productName, productPrice);
        });
    });

    // --- Carousel Logic ---
    window.currentSlide = 0;
    window.slides = document.querySelectorAll('.product-slide');
    window.dots = document.querySelectorAll('.dot');
    function updateSlide(index) {
        window.slides.forEach(slide => slide.classList.remove('active'));
        window.dots.forEach(dot => dot.classList.remove('active'));
        window.slides[index].classList.add('active');
        window.dots[index].classList.add('active');
        window.currentSlide = index;
    }
    window.showSlide = function(n) {
        if (n < 0) n = 0;
        if (n >= window.slides.length) n = window.slides.length - 1;
        updateSlide(n);
    };
    window.nextSlide = function() {
        if (window.currentSlide < window.slides.length - 1) {
            updateSlide(window.currentSlide + 1);
        }
    };
    window.prevSlide = function() {
        if (window.currentSlide > 0) {
            updateSlide(window.currentSlide - 1);
        }
    };
    // Initialize first slide
    if (window.slides.length > 0) updateSlide(0);
});

function submitOrder() {
    // Generate order number - simple timestamp-based ID
    const orderNumber = 'GB-' + Date.now().toString().slice(-6);
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
    // Create the confirmation page content
    let pickupDetails = '';
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
    }
    const confirmationHTML = `
        <div class="confirmation-page">
            <div class="confirmation-container">
                <h2>Thank You for Your Order!</h2>
                <p class="order-number">Order #${orderNumber}</p>
                <p class="order-total">Total: $${orderTotal.toFixed(2)}</p>
                ${pickupDetails}
                <div class="order-confirmation">
                    <p class="confirmation-message">Katerina will confirm receipt of payment and order ready date.</p>
                    <p>You can pay directly to <strong>@katvalderrama</strong> via Venmo.</p>
                    <p>Please include your order number <strong>#${orderNumber}</strong> in the notes.</p>
                </div>
                <div class="info-box catering-info">
                    <strong>Available for large dinners and catering.</strong>
                </div>
                ${emailSent ? `
                <div class="email-confirmation">
                    <p>A confirmation email has been sent to your email address.</p>
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

function calculateCartTotal() {
    return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
}

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
    const cartItemsContainer = document.querySelectorAll('.cart-items');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    const cartTotalEls = document.querySelectorAll('.cart-total');
    let total = 0;
    let itemCount = 0;

    cartItemsContainer.forEach(container => {
        if (!container) return;
        container.innerHTML = '';
        if (cart.length === 0) {
            if (emptyCartMessage) emptyCartMessage.style.display = 'block';
            cartTotalEls.forEach(el => el.textContent = 'Total: $0.00');
            return;
        }
        if (emptyCartMessage) emptyCartMessage.style.display = 'none';
        // Table header
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
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            itemCount += item.quantity;
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="item-name">${item.name}</td>
                <td class="item-qty">
                    <span class="qty-controls">
                        <span class="qty-link" onclick="updateQuantity('${item.id}', ${item.quantity - 1})">−</span>
                        <input type="number" min="0" value="${item.quantity}" onchange="updateQuantity('${item.id}', parseInt(this.value) || 0)" class="quantity-input">
                        <span class="qty-link" onclick="updateQuantity('${item.id}', ${item.quantity + 1})">+</span>
                    </span>
                </td>
                <td class="item-price">$${(itemTotal).toFixed(2)}</td>
                <td class="item-remove"><button class="remove-item" onclick="removeFromCart('${item.id}')">×</button></td>
            `