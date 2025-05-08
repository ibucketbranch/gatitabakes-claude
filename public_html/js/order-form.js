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
            
            addToCart(productId, productName, productPrice);
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
        emptyCartMessage.style.display = 'block';
        cartTotal.textContent = 'Total: $0.00';
        return;
    }
    
    emptyCartMessage.style.display = 'none';
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
                    <span>${item.quantity}</span>
                    <button class="quantity-btn" onclick="updateQuantity('${item.id}', ${item.quantity + 1})">+</button>
                </div>
                <span class="item-price">$${(itemTotal).toFixed(2)}</span>
                <button class="remove-item" onclick="removeFromCart('${item.id}')">×</button>
            </div>
        `;
        
        cartItemsContainer.appendChild(itemElement);
    });
    
    cartTotal.textContent = `Total: $${total.toFixed(2)}`;
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
        const response = await fetch(`${baseURL}/submit-order.php`, {
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
