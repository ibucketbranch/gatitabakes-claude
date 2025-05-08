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
        max-height: 400px;
        overflow-y: auto;
        margin-bottom: 20px;
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
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }

    .item-details {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .item-quantity {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quantity-btn {
        background: #8b4513;
        color: white;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .remove-item {
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        font-size: 18px;
        padding: 0 8px;
    }
</style>';
require_once 'includes/header.php';
?>
    
<h1>Order Form Test</h1>

<div class="main-container">
    <div class="order-section">
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

        <form id="order-form" class="order-form">
            <div class="form-section">
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

            <div class="form-section">
                <h2>Order Type</h2>
                <div class="order-type-section">
                    <div class="order-type-option active" id="pickup-option">
                        <input type="radio" name="order_type" value="pickup" checked id="pickup-radio">
                        <label for="pickup-radio">
                            <h3>Pickup</h3>
                            <p>Pick up your order from our location</p>
                        </label>
                    </div>
                    <div class="order-type-option" id="delivery-option">
                        <input type="radio" name="order_type" value="delivery" id="delivery-radio">
                        <label for="delivery-radio">
                            <h3>Delivery</h3>
                            <p>Get your order delivered to your address</p>
                        </label>
                    </div>
                </div>

                <div id="pickup-location-fields">
                    <div class="form-group">
                        <label for="pickup-location">Pickup Location</label>
                        <select id="pickup-location" name="pickup-location" required>
                            <option value="">Select a pickup location</option>
                            <option value="location1">Location 1</option>
                            <option value="location2">Location 2</option>
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
                        <input type="text" id="delivery-address" name="delivery-address" required>
                    </div>
                    <div class="form-group">
                        <label for="delivery-unit">Apt/Suite/Unit</label>
                        <input type="text" id="delivery-unit" name="delivery-unit">
                    </div>
                    <div class="form-group">
                        <label for="delivery-city">City</label>
                        <input type="text" id="delivery-city" name="delivery-city" required>
                    </div>
                    <div class="form-group">
                        <label for="delivery-notes">Delivery Instructions</label>
                        <textarea id="delivery-notes" name="delivery-notes"></textarea>
                    </div>
                </div>
            </div>

            <div class="submit-section">
                <button type="submit">Place Order</button>
                <div class="payment-info">
                    Please pay using Venmo link in confirmation email - @katvalderrama
                </div>
            </div>
        </form>
    </div>

    <div class="cart-summary">
        <h2>Order Summary</h2>
        <div class="cart-items">
            <!-- Cart items will be inserted here by JavaScript -->
        </div>
        <div id="empty-cart-message">Your cart is empty. Add some delicious bread!</div>
        <div class="cart-total">Total: $0.00</div>
    </div>
</div>

<script>
    // Carousel functionality
    let currentSlide = 0;
    const slides = document.querySelectorAll('.product-slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');

    function showSlide(n) {
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');
        currentSlide = n;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
        
        // Update arrow buttons
        prevBtn.disabled = currentSlide === 0;
        nextBtn.disabled = currentSlide === slides.length - 1;
    }

    function nextSlide() {
        if (currentSlide < slides.length - 1) {
            showSlide(currentSlide + 1);
        }
    }

    function prevSlide() {
        if (currentSlide > 0) {
            showSlide(currentSlide - 1);
        }
    }

    // Initialize carousel
    showSlide(0);

    // Your existing cart functionality
    let cart = [];
    
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize cart from localStorage if available
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            cart = JSON.parse(savedCart);
            updateCartDisplay();
        }

        // Add event listeners for add to cart buttons
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.id;
                const productPrice = parseFloat(this.dataset.price);
                const productName = this.closest('.product-card').querySelector('h3').textContent;
                
                addToCart(productId, productName, productPrice);
            });
        });

        // Handle order type toggle
        const orderTypeInputs = document.querySelectorAll('input[name="order_type"]');
        const pickupFields = document.getElementById('pickup-location-fields');
        const deliveryFields = document.getElementById('delivery-address-fields');
        const pickupLocationSelect = document.getElementById('pickup-location');
        const deliveryInputs = deliveryFields.querySelectorAll('input[required]');
        const pickupOption = document.getElementById('pickup-option');
        const deliveryOption = document.getElementById('delivery-option');

        orderTypeInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.value === 'pickup') {
                    pickupFields.style.display = 'block';
                    deliveryFields.style.display = 'none';
                    pickupLocationSelect.required = true;
                    deliveryInputs.forEach(input => input.required = false);
                    pickupOption.classList.add('active');
                    deliveryOption.classList.remove('active');
                } else {
                    pickupFields.style.display = 'none';
                    deliveryFields.style.display = 'block';
                    pickupLocationSelect.required = false;
                    deliveryInputs.forEach(input => input.required = true);
                    deliveryOption.classList.add('active');
                    pickupOption.classList.remove('active');
                }
            });
        });

        // Add click handlers for the order type option containers
        pickupOption.addEventListener('click', () => {
            document.querySelector('input[value="pickup"]').click();
        });
        
        deliveryOption.addEventListener('click', () => {
            document.querySelector('input[value="delivery"]').click();
        });

        // Handle form submission
        const orderForm = document.getElementById('order-form');
        if (orderForm) {
            orderForm.addEventListener('submit', handleSubmit);
        }
    });

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
        const emptyCartMessage = document.getElementById('empty-cart-message');
        const cartTotal = document.querySelector('.cart-total');
        
        if (!cartItemsContainer) return;
        
        cartItemsContainer.innerHTML = '';
        
        if (cart.length === 0) {
            if (emptyCartMessage) emptyCartMessage.style.display = 'block';
            if (cartTotal) cartTotal.textContent = 'Total: $0.00';
            return;
        }
        
        if (emptyCartMessage) emptyCartMessage.style.display = 'none';
        let total = 0;
        
        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            
            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';
            itemElement.innerHTML = `
                <div class="item-details">
                    <span class="item-name">${item.name}</span>
                    <div class="item-quantity">
                        <button class="quantity-btn" onclick="updateQuantity('${item.id}', ${item.quantity - 1})">-</button>
                        <input type="number" 
                               min="0" 
                               value="${item.quantity}" 
                               onchange="updateQuantity('${item.id}', parseInt(this.value) || 0)"
                               class="quantity-input">
                        <button class="quantity-btn" onclick="updateQuantity('${item.id}', ${item.quantity + 1})">+</button>
                    </div>
                    <span class="item-price">$${(itemTotal).toFixed(2)}</span>
                    <button class="remove-item" onclick="removeFromCart('${item.id}')">×</button>
                </div>
            `;
            
            cartItemsContainer.appendChild(itemElement);
        });
        
        if (cartTotal) cartTotal.textContent = `Total: $${total.toFixed(2)}`;
    }

    async function handleSubmit(event) {
        event.preventDefault();
        
        if (cart.length === 0) {
            alert('Please add items to your cart before submitting the order.');
            return;
        }
        
        const formData = new FormData(event.target);
        const orderData = {
            customer: {
                firstName: formData.get('first-name'),
                lastName: formData.get('last-name'),
                email: formData.get('email'),
                phone: formData.get('phone')
            },
            orderType: formData.get('order_type'),
            items: cart,
            notes: formData.get(formData.get('order_type') === 'pickup' ? 'pickup-notes' : 'delivery-notes')
        };
        
        if (orderData.orderType === 'pickup') {
            orderData.pickupLocation = formData.get('pickup-location');
        } else {
            orderData.deliveryAddress = {
                street: formData.get('delivery-address'),
                unit: formData.get('delivery-unit'),
                city: formData.get('delivery-city')
            };
        }
        
        try {
            const response = await fetch('includes/process-order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(orderData)
            });
            
            if (response.ok) {
                const result = await response.json();
                alert('Order submitted successfully! Check your email for confirmation.');
                cart = [];
                localStorage.removeItem('cart');
                updateCartDisplay();
                event.target.reset();
            } else {
                throw new Error('Failed to submit order');
            }
        } catch (error) {
            console.error('Error submitting order:', error);
            alert('There was an error submitting your order. Please try again.');
        }
    }

    // Add validation function
    function validatePickupLocation() {
        const pickupLocation = document.getElementById('pickup-location');
        if (document.getElementById('delivery-type-pickup').checked && !pickupLocation.value) {
            pickupLocation.setCustomValidity('Please select a pickup location');
            return false;
        }
        pickupLocation.setCustomValidity('');
        return true;
    }

    // Add to form submission
    document.getElementById('order-form').addEventListener('submit', function(e) {
        if (!validatePickupLocation()) {
            e.preventDefault();
            return false;
        }
        // ... existing form submission code ...
    });
</script>
<?php require_once 'includes/footer.php'; ?> 