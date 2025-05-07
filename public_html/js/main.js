// Main JavaScript for Gatita Bakes

document.addEventListener('DOMContentLoaded', function() {
    // Initialize the order form and cart
    initializeOrderForm();
    initializeCart();
    setupNavigation();
});

// Product data
const products = {
    'plain-sourdough': { name: 'Plain Sourdough', price: 8.00 },
    'everything-sourdough': { name: 'Everything Sourdough', price: 9.00 },
    'rosemary-sourdough': { name: 'Rosemary Sourdough', price: 9.00 },
    'plain-bagels': { name: 'Plain Bagels', price: 3.00 },
    'jalapeno-cheese-bagels': { name: 'Jalapeño Cheese Bagels', price: 3.50 }
};

// Cart state
let cart = [];

function initializeCart() {
    // Add to cart button listeners
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.product;
            addToCart(productId);
        });
    });

    // Initialize cart display
    updateCartDisplay();
}

function addToCart(productId) {
    const product = products[productId];
    if (product) {
        cart.push({
            id: productId,
            name: product.name,
            price: product.price
        });
        updateCartDisplay();
        showNotification('Added ' + product.name + ' to cart', 'success');
    }
}

function updateCartDisplay() {
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    
    // Clear current display
    cartItems.innerHTML = '';
    
    // Add each item
    cart.forEach((item, index) => {
        const itemElement = document.createElement('div');
        itemElement.className = 'cart-item';
        itemElement.innerHTML = `
            <span class="item-name">${item.name}</span>
            <span class="item-price">$${item.price.toFixed(2)}</span>
            <button class="remove-item" onclick="removeFromCart(${index})">Remove</button>
        `;
        cartItems.appendChild(itemElement);
    });
    
    // Update total
    const total = cart.reduce((sum, item) => sum + item.price, 0);
    cartTotal.textContent = '$' + total.toFixed(2);
}

function removeFromCart(index) {
    const removed = cart.splice(index, 1)[0];
    updateCartDisplay();
    showNotification('Removed ' + removed.name + ' from cart', 'success');
}

function initializeOrderForm() {
    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        orderForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleOrderSubmission();
        });
    }

    // Set minimum date for pickup
    const pickupDate = document.getElementById('pickup-date');
    if (pickupDate) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        pickupDate.min = tomorrow.toISOString().split('T')[0];
    }
}

function setupNavigation() {
    // Smooth scroll for navigation links
    document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add active class to navigation items on scroll
    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('nav ul li a');
        
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (window.pageYOffset >= sectionTop - 60) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
}

async function handleOrderSubmission() {
    if (cart.length === 0) {
        showNotification('Please add items to your cart before ordering', 'error');
        return;
    }

    const formData = new FormData(document.getElementById('order-form'));
    formData.append('cart', JSON.stringify(cart));
    
    try {
        const response = await fetch('../includes/process-order.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('Order submitted successfully!', 'success');
            cart = [];
            updateCartDisplay();
            document.getElementById('order-form').reset();
        } else {
            showNotification(result.message || 'Error submitting order. Please try again.', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('An unexpected error occurred.', 'error');
    }
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
} 