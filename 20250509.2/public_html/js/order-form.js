/**
 * Project: Gatita Bakes Online Order System
 * Title: Order Form JavaScript
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-05-09
 */

// Cart functionality
let cart = [];
const baseURL = window.location.origin;

document.addEventListener('DOMContentLoaded', function() {
    console.log('Order form script loaded');
    
    // Initialize cart from localStorage if available
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        try {
            cart = JSON.parse(savedCart);
            updateCartDisplay();
        } catch (e) {
            console.error('Error parsing saved cart:', e);
            localStorage.removeItem('cart');
            cart = [];
        }
    }

    // Add event listeners for add to cart buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            const productPrice = parseFloat(this.dataset.price);
            const productName = this.closest('.product-card').querySelector('h3').textContent;
            const productImage = this.closest('.product-card').querySelector('img').src;
            
            addToCart(productId, productName, productPrice, productImage);
        });
    });

    // Handle order type toggle
    const orderTypeInputs = document.querySelectorAll('input[name="order_type"]');
    const pickupFields = document.getElementById('pickup-location-fields');
    const deliveryFields = document.getElementById('delivery-address-fields');

    orderTypeInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.value === 'pickup') {
                pickupFields.style.display = 'block';
                deliveryFields.style.display = 'none';
            } else {
                pickupFields.style.display = 'none';
                deliveryFields.style.display = 'block';
            }
        });
    });

    // Navigation logic for steps
    const steps = document.querySelectorAll('.step');
    const nextBtn = document.getElementById('next-btn');
    const backBtn = document.getElementById('back-btn');
    let currentStep = 1;

    function updateNavButtons() {
        if (currentStep === 1) {
            backBtn.style.display = 'none';
            nextBtn.style.display = 'inline-flex';
        } else if (currentStep === steps.length) {
            backBtn.style.display = 'inline-flex';
            nextBtn.style.display = 'none';
        } else {
            backBtn.style.display = 'inline-flex';
            nextBtn.style.display = 'inline-flex';
        }
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            // Validate current step before proceeding
            if (currentStep === 1) {
                // Check if order type is selected
                const orderTypeSelected = document.querySelector('input[name="order_type"]:checked');
                if (!orderTypeSelected) {
                    alert('Please select an order type (Pickup or Delivery)');
                    return;
                }
                
                // Check if cart has items
                if (cart.length === 0) {
                    alert('Please add at least one item to your cart before continuing');
                    return;
                }
            }
            
            if (currentStep < steps.length) {
                steps[currentStep - 1].style.display = 'none';
                steps[currentStep].style.display = 'block';
                currentStep++;
                updateNavButtons();
            }
        });
    }

    if (backBtn) {
        backBtn.addEventListener('click', function() {
            if (currentStep > 1) {
                steps[currentStep - 1].style.display = 'none';
                steps[currentStep - 2].style.display = 'block';
                currentStep--;
                updateNavButtons();
            }
        });
    }

    // Initialize step visibility
    if (steps.length > 0) {
        steps.forEach((step, idx) => {
            step.style.display = idx === 0 ? 'block' : 'none';
        });
        updateNavButtons();
    }

    // Add submit handler to the place order button
    const placeOrderBtn = document.querySelector('.place-order-btn');
    if (placeOrderBtn) {
        placeOrderBtn.addEventListener('click', function(e) {
            submitOrder(e);
        });
    }
});

function addToCart(productId, productName, price, imageUrl) {
    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: productId,
            name: productName,
            price: price,
            quantity: 1,
            image: imageUrl
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
    
    // Show brief animation or feedback
    const addButton = document.querySelector(`.add-to-cart[data-id="${productId}"]`);
    if (addButton) {
        addButton.textContent = "Added!";
        addButton.classList.add("added");
        setTimeout(() => {
            addButton.textContent = "Add to Cart";
            addButton.classList.remove("added");
        }, 1000);
    }
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
    const sidebarCartTotal = document.querySelector('.sidebar-cart-total');
    
    if (!sidebarCartItems || !sidebarCartTotal) {
        console.error('Cart display elements not found');
        return;
    }
    
    sidebarCartItems.innerHTML = '';
    
    if (cart.length === 0) {
        sidebarCartItems.innerHTML = '<p class="empty-cart-message">Your cart is empty</p>';
        sidebarCartTotal.textContent = 'Total: $0.00';
        return;
    }
    
    let total = 0;
    
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        const itemElement = document.createElement('div');
        itemElement.className = 'cart-item';
        itemElement.innerHTML = `
            <div class="item-details">
                <span class="item-name">${item.name} (${item.quantity})</span>
                <span class="item-price">$${(itemTotal).toFixed(2)}</span>
                <button class="remove-item" onclick="removeFromCart('${item.id}')">×</button>
            </div>
        `;
        
        sidebarCartItems.appendChild(itemElement);
    });
    
    sidebarCartTotal.textContent = `Total: $${total.toFixed(2)}`;
}

function submitOrder(event) {
    if (event) {
        event.preventDefault();
    }
    
    console.log('Submit order function called');
    
    if (cart.length === 0) {
        alert('Please add items to your cart before submitting the order.');
        return;
    }
    
    const form = document.getElementById('order-form');
    if (!form) {
        console.error('Order form not found');
        return;
    }
    
    // For step 1, check if order type is selected
    const orderType = document.querySelector('input[name="order_type"]:checked');
    if (!orderType) {
        alert('Please select an order type (Pickup or Delivery)');
        return;
    }
    
    // For step 2 (the form fields), we need to ensure they're filled
    // Get only the visible required fields based on order type
    const requiredFields = [];
    
    if (orderType.value === 'pickup') {
        const pickupLocation = document.getElementById('pickup-location');
        if (pickupLocation) {
            requiredFields.push(pickupLocation);
        } else {
            console.error('Pickup location field not found');
        }
    } else {
        const addressFields = [
            document.getElementById('delivery-address'),
            document.getElementById('delivery-city'),
            document.getElementById('delivery-zip')
        ];
        
        addressFields.forEach(field => {
            if (field) {
                requiredFields.push(field);
            } else {
                console.error('Required delivery field not found');
            }
        });
    }
    
    // Common required fields
    const contactFields = [
        document.getElementById('first-name'),
        document.getElementById('last-name'),
        document.getElementById('email'),
        document.getElementById('phone')
    ];
    
    contactFields.forEach(field => {
        if (field) {
            requiredFields.push(field);
        } else {
            console.error('Required contact field not found');
        }
    });
    
    // Validate all required fields
    let isValid = true;
    for (const field of requiredFields) {
        if (!field.value.trim()) {
            field.classList.add('error');
            field.style.borderColor = '#ff6b6b';
            isValid = false;
        } else {
            field.classList.remove('error');
            field.style.borderColor = '';
        }
    }
    
    if (!isValid) {
        alert('Please fill in all required fields');
        return;
    }
    
    // Generate a simple order number
    const orderNumber = 'GB' + Date.now().toString().slice(-6);
    
    // Build the order data
    const formData = new FormData(form);
    const orderData = {
        orderNumber: orderNumber,
        customer: {
            firstName: formData.get('first-name'),
            lastName: formData.get('last-name'),
            email: formData.get('email'),
            phone: formData.get('phone')
        },
        orderType: orderType.value,
        items: cart,
        orderDate: new Date().toISOString()
    };
    
    if (orderData.orderType === 'pickup') {
        orderData.pickupLocation = formData.get('pickup-location');
    } else {
        orderData.deliveryAddress = {
            street: formData.get('delivery-address'),
            unit: formData.get('delivery-unit') || '',
            city: formData.get('delivery-city'),
            state: formData.get('delivery-state'),
            zip: formData.get('delivery-zip')
        };
    }
    
    // Disable the submit button and show loading state
    const submitBtn = document.querySelector('.place-order-btn');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
        submitBtn.style.opacity = '0.7';
    }
    
    console.log('Submitting order data:', orderData);
    
    // Submit the order via AJAX
    fetch('includes/process-order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderData)
    })
    .then(response => {
        console.log('Response received:', response);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Order processed:', data);
        if (data.success) {
            // Clear cart and show success message
            cart = [];
            localStorage.removeItem('cart');
            updateCartDisplay();
            form.reset();
            
            alert(`Order #${data.orderNumber} submitted successfully! Check your email for confirmation.`);
            
            // Redirect to confirmation page
            window.location.href = 'order-confirmation.php?order=' + data.orderNumber;
        } else {
            // Enable the button again
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Place Order';
                submitBtn.style.opacity = '1';
            }
            
            alert('Error: ' + (data.message || 'Unknown error occurred'));
        }
    })
    .catch(error => {
        console.error('Error submitting order:', error);
        
        // Enable the button again
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Place Order';
            submitBtn.style.opacity = '1';
        }
        
        alert('There was an error submitting your order. Please try again or contact us for assistance.');
    });
}
