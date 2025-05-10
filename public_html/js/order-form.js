/**
 * Project: Gatita Bakes Online Order System
 * Title: Order Form JavaScript
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250510.2
 * Date: 2025-05-10
 */

// Cart functionality
let cart = [
    { id: 'plain-sourdough', name: 'Plain Sourdough', price: 8.00, quantity: 2 },
    { id: 'everything-sourdough', name: 'Everything Sourdough', price: 9.00, quantity: 1 }
];
const baseURL = window.location.origin;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart from localStorage if available
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartDisplay();
    }

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

    // Initialize with proper display based on default selection
    const defaultOrderType = document.querySelector('input[name="order_type"]:checked');
    if (defaultOrderType) {
        if (defaultOrderType.value === 'pickup') {
            pickupFields.style.display = 'block';
            deliveryFields.style.display = 'none';
        } else {
            pickupFields.style.display = 'none';
            deliveryFields.style.display = 'block';
        }
    }

    // Handle remove item buttons in cart
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            removeFromCart(productId);
        });
    });

    // Handle form submission
    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        orderForm.addEventListener('submit', handleSubmit);
    }
});

function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

function updateCartDisplay() {
    const cartItemsContainer = document.getElementById('sidebar-cart-items');
    const cartTotal = document.getElementById('cart-total');
    
    if (!cartItemsContainer) return;
    
    // Clear existing items
    cartItemsContainer.innerHTML = '';
    
    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '<p class="empty-cart-message">Your cart is empty</p>';
        if (cartTotal) cartTotal.textContent = '$0.00';
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
                <span class="item-name">${item.name}</span>
                <span class="item-quantity">× ${item.quantity}</span>
                <span class="item-price">$${(itemTotal).toFixed(2)}</span>
            </div>
            <button class="remove-item" data-id="${item.id}">×</button>
        `;
        
        cartItemsContainer.appendChild(itemElement);
        
        // Add event listener to the newly created remove button
        itemElement.querySelector('.remove-item').addEventListener('click', function() {
            removeFromCart(this.dataset.id);
        });
    });
    
    if (cartTotal) cartTotal.textContent = `$${total.toFixed(2)}`;
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
            fullName: formData.get('full-name'),
            email: formData.get('email'),
            phone: formData.get('phone')
        },
        orderType: formData.get('order_type'),
        paymentMethod: formData.get('payment-method'),
        items: cart.map(item => ({
            id: item.id,
            name: item.name,
            price: item.price,
            quantity: item.quantity,
            subtotal: item.price * item.quantity
        })),
        total: cart.reduce((sum, item) => sum + (item.price * item.quantity), 0)
    };
    
    // Add delivery or pickup specific data
    if (orderData.orderType === 'pickup') {
        orderData.pickup = {
            location: formData.get('pickup-location'),
            time: formData.get('pickup-time'),
        };
    } else {
        orderData.delivery = {
            address: formData.get('delivery-address'),
            unit: formData.get('delivery-unit'),
            city: formData.get('delivery-city'),
            zip: formData.get('delivery-zip'),
            notes: formData.get('delivery-notes')
        };
    }
    
    try {
        // Here you would normally send data to server
        console.log('Order data to submit:', orderData);
        
        // For demo purposes, simulate a successful order
        alert('Order submitted successfully! You will receive a confirmation email shortly.');
        
        // Clear cart after successful order
        cart = [];
        localStorage.removeItem('cart');
        
        // Redirect to confirmation page
        // window.location.href = `${baseURL}/order-confirmation.php?id=${response.orderId}`;
    } catch (error) {
        console.error('Error submitting order:', error);
        alert('There was an error submitting your order. Please try again.');
    }
}
