/**
 * Project: Gatita Bakes Online Order System
 * Title: Order Form JavaScript
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-05-09
 */

// Project Header: Order Form JavaScript
// Description: Handles the order form logic and interactions
// Author: [Your Name]
// Date: [Today's Date]

// Cart functionality
let cart = [];
const baseURL = window.location.origin;

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

    backBtn.addEventListener('click', function() {
        if (currentStep > 1) {
            steps[currentStep - 1].style.display = 'none';
            steps[currentStep - 2].style.display = 'block';
            currentStep--;
            updateNavButtons();
        }
    });

    // Initialize step visibility
    steps.forEach((step, idx) => {
        step.style.display = idx === 0 ? 'block' : 'none';
    });
    updateNavButtons();

    // Handle form submission
    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        orderForm.addEventListener('submit', submitOrder);
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
    
    if (!sidebarCartItems || !sidebarCartTotal) return;
    
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
    event.preventDefault();
    
    if (cart.length === 0) {
        alert('Please add items to your cart before submitting the order.');
        return;
    }
    
    const form = document.getElementById('order-form');
    if (!form) return;
    
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
        requiredFields.push(document.getElementById('pickup-location'));
    } else {
        requiredFields.push(
            document.getElementById('delivery-address'),
            document.getElementById('delivery-city'),
            document.getElementById('delivery-zip')
        );
    }
    
    // Common required fields
    requiredFields.push(
        document.getElementById('first-name'),
        document.getElementById('last-name'),
        document.getElementById('email'),
        document.getElementById('phone')
    );
    
    // Validate all required fields
    let isValid = true;
    for (const field of requiredFields) {
        if (!field.value.trim()) {
            field.classList.add('error');
            isValid = false;
        } else {
            field.classList.remove('error');
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
    
    // Submit the order via AJAX
    fetch('includes/process-order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Order #${data.orderNumber} submitted successfully! Check your email for confirmation.`);
            cart = [];
            localStorage.removeItem('cart');
            updateCartDisplay();
            form.reset();
            window.location.href = 'order-confirmation.php?order=' + data.orderNumber;
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error submitting order:', error);
        alert('There was an error submitting your order. Please try again.');
    });
}
