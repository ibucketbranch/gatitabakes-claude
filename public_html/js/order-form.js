// Cart functionality
let cart = [];

// Initialize cart from localStorage if available
document.addEventListener('DOMContentLoaded', function() {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartDisplay();
    }

    // Initialize form navigation
    const steps = document.querySelectorAll('.form-section');
    let currentStep = 0;

    // Show first step
    showStep(currentStep);

    // Add event listeners for navigation buttons
    document.querySelectorAll('.next-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                showStep(currentStep + 1);
            }
        });
    });

    document.querySelectorAll('.back-btn').forEach(btn => {
        btn.addEventListener('click', () => {
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
});

// Form navigation functions
function showStep(n) {
    const steps = document.querySelectorAll('.form-section');
    
    // Validate step bounds
    if (n < 0) n = 0;
    if (n >= steps.length) n = steps.length - 1;
    
    // Hide all steps
    steps.forEach(step => {
        step.style.display = 'none';
    });
    
    // Show the current step
    if (steps[n]) {
        steps[n].style.display = 'block';
        currentStep = n;
    }
    
    // Update navigation buttons
    updateNavigationButtons();
}

function updateNavigationButtons() {
    const backButtons = document.querySelectorAll('.back-btn');
    const nextButtons = document.querySelectorAll('.next-btn');
    
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
            btn.innerHTML = 'Next <span class="arrow">→</span>';
            btn.classList.remove('place-order-btn');
        }
    });
}

function validateStep(step) {
    switch(step) {
        case 0:
            const orderType = document.querySelector('input[name="order_type"]:checked');
            if (!orderType) {
                alert('Please select Pickup or Delivery.');
                return false;
            }
            return true;
            
        case 1:
            // Validate contact info
            const requiredFields = ['first-name', 'last-name', 'email', 'phone'];
            for (const field of requiredFields) {
                if (!document.getElementById(field)?.value) {
                    alert('Please fill out all contact information fields.');
                    return false;
                }
            }
            
            // Validate delivery/pickup specific fields
            const orderTypeValue = document.querySelector('input[name="order_type"]:checked')?.value;
            if (orderTypeValue === 'delivery') {
                const deliveryFields = ['delivery-address', 'delivery-city', 'delivery-zip'];
                for (const field of deliveryFields) {
                    if (!document.getElementById(field)?.value) {
                        alert('Please fill out all required delivery address fields.');
                        return false;
                    }
                }
            } else {
                if (!document.getElementById('pickup-location')?.value) {
                    alert('Please select a pickup location.');
                    return false;
                }
            }
            return true;
            
        default:
            return true;
    }
}

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
    const sidebarCartItems = document.querySelector('.sidebar-cart-items');
    const total = calculateCartTotal();

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

    // Update total display
    document.querySelector('.sidebar-cart-total').textContent = `Total: $${total.toFixed(2)}`;
}

function calculateCartTotal() {
    return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
}

function generateOrderNumber() {
    const year = new Date().getFullYear().toString().slice(-2);
    let yearKey = `orderCounter${year}`;
    let counter = localStorage.getItem(yearKey);
    
    if (!counter) {
        counter = 1;
    } else {
        counter = parseInt(counter) + 1;
        if (counter > 9999) counter = 1;
    }
    
    localStorage.setItem(yearKey, counter);
    const paddedCounter = counter.toString().padStart(4, '0');
    return `GB-${year}${paddedCounter}`;
}

function submitOrder() {
    if (cart.length === 0) {
        alert('Please add at least one item to your cart.');
        return;
    }

    const orderNumber = generateOrderNumber();
    const orderTotal = calculateCartTotal();
    const orderType = document.querySelector('input[name="order_type"]:checked')?.value;
    
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
    
    if (orderType === 'delivery') {
        orderData.deliveryAddress = {
            street: document.getElementById('delivery-address').value,
            unit: document.getElementById('delivery-unit').value || '',
            city: document.getElementById('delivery-city').value,
            state: document.getElementById('delivery-state').value,
            zip: document.getElementById('delivery-zip').value
        };
    } else {
        orderData.pickupLocation = document.getElementById('pickup-location').value;
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
        showConfirmationPage(orderNumber, orderTotal, result.success, orderType, orderData.pickupLocation);
    })
    .catch(error => {
        console.error('Error processing order:', error);
        showConfirmationPage(orderNumber, orderTotal, false, orderType, orderData.pickupLocation);
    });
    
    // Reset cart
    cart = [];
    localStorage.removeItem('cart');
}

function showConfirmationPage(orderNumber, orderTotal, emailSent, orderType, pickupLocation) {
    const firstName = document.getElementById('first-name')?.value || '';
    const email = document.getElementById('email')?.value || '';
    
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
            pickupDetails = `
                <div class="pickup-info">
                    <p><strong>Pickup Location:</strong> Sac Farmers Market</p>
                    <p>Katerina will provide specific market location and time details when confirming your order.</p>
                </div>
            `;
        }
    }

    const confirmationHTML = `
        <div class="confirmation-page">
            <div class="confirmation-container">
          <h2>Thank You for Your Order!</h2>
                <p class="order-number">Order #${orderNumber}</p>
                <p class="order-total">Total: $${orderTotal.toFixed(2)}</p>
                <p class="confirmation-message">${firstName ? `${firstName}, thank you for your order!` : 'Thank you for your order!'}</p>
                ${pickupDetails}
                <div class="order-confirmation">
                    <p class="confirmation-message">Katerina will confirm receipt of payment and order ready date.</p>
                    <p>You can pay directly to <strong>@katvalderrama</strong> via Venmo.</p>
                    <p>Please include your order number <strong>#${orderNumber}</strong> in the notes.</p>
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
                <div class="order-more">
                    <a href="javascript:location.reload()" class="order-more-btn">Order More! 😊</a>
                    <a href="/" class="return-home-btn">Return Home</a>
          </div>
        </div>
      </div>
    `;
    
    document.body.innerHTML = confirmationHTML;
}

function generateVenmoLink(orderNumber, amount) {
    const venmoUsername = 'katvalderrama';
    const note = `Gatita Bakes Order #${orderNumber}`;
    
    if (/Android|iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        return `venmo://paycharge?txn=pay&recipients=${venmoUsername}&amount=${amount}&note=${encodeURIComponent(note)}`;
    }
    
    return `https://venmo.com/${venmoUsername}?txn=pay&amount=${amount}&note=${encodeURIComponent(note)}`;
}
