/**
 * Project: Gatita Bakes Online Order System
 * Title: App JavaScript
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-05-09
 */

// Cart functionality
const cart = {
    items: {},
    
    addItem: function(id, name, price) {
        if (!id || !name || isNaN(price)) {
            console.error('Invalid item data:', { id, name, price });
            return;
        }
        
        console.log('Adding item to cart:', { id, name, price });
        
        if (this.items[id]) {
            this.items[id].quantity++;
        } else {
            this.items[id] = {
                name: name,
                price: parseFloat(price),
                quantity: 1
            };
        }
        
        this.saveToStorage();
        this.updateUI();
        this.showNotification('Item added to cart!');
    },
    
    removeItem: function(id) {
        if (this.items[id]) {
            delete this.items[id];
            this.saveToStorage();
            this.updateUI();
            this.showNotification('Item removed from cart');
        }
    },
    
    updateQuantity: function(id, quantity) {
        if (this.items[id]) {
            if (quantity <= 0) {
                this.removeItem(id);
            } else {
                this.items[id].quantity = Math.min(10, Math.max(1, quantity));
                this.saveToStorage();
                this.updateUI();
            }
        }
    },
    
    saveToStorage: function() {
        localStorage.setItem('gatitaCart', JSON.stringify(this.items));
    },
    
    loadFromStorage: function() {
        const stored = localStorage.getItem('gatitaCart');
        if (stored) {
            try {
                this.items = JSON.parse(stored);
                this.updateUI();
            } catch (e) {
                console.error('Error loading cart:', e);
                this.items = {};
            }
        }
    },
    
    getTotal: function() {
        return Object.values(this.items).reduce((total, item) => {
            return total + (item.price * item.quantity);
        }, 0);
    },
    
    updateUI: function() {
        const cartSummary = document.getElementById('cart-summary');
        if (!cartSummary) return;
        
        const itemsContainer = cartSummary.querySelector('.cart-items');
        if (!itemsContainer) return;
        
        itemsContainer.innerHTML = '';
        
        Object.entries(this.items).forEach(([id, item]) => {
            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';
            itemElement.innerHTML = `
                <div class="item-info">
                    <span class="item-name">${item.name}</span>
                    <div class="quantity-controls">
                        <button class="quantity-decrease" data-id="${id}">-</button>
                        <input type="number" value="${item.quantity}" min="1" max="10" 
                               class="quantity-input" data-id="${id}">
                        <button class="quantity-increase" data-id="${id}">+</button>
                    </div>
                </div>
                <div class="item-price">$${(item.price * item.quantity).toFixed(2)}</div>
                <button class="remove-item" data-id="${id}">&times;</button>
            `;
            itemsContainer.appendChild(itemElement);
        });
        
        // Update total
        const total = this.getTotal();
        const totalElement = cartSummary.querySelector('.cart-total');
        if (totalElement) {
            totalElement.textContent = `Total: $${total.toFixed(2)}`;
        }
        
        // Update empty cart message visibility
        const emptyMessage = document.getElementById('empty-cart-message');
        if (emptyMessage) {
            emptyMessage.style.display = Object.keys(this.items).length === 0 ? 'block' : 'none';
        }
    },
    
    showNotification: function(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    }
};

// Form handling
function toggleDeliveryFields() {
    const pickupFields = document.getElementById('pickup-location-fields');
    const deliveryFields = document.getElementById('delivery-address-fields');
    const orderType = document.querySelector('input[name="order_type"]:checked').value;

    if (orderType === 'pickup') {
        pickupFields.style.display = 'block';
        deliveryFields.style.display = 'none';
        // Toggle required fields
        document.querySelectorAll('#pickup-location-fields input, #pickup-location-fields select').forEach(field => {
            field.required = true;
        });
        document.querySelectorAll('#delivery-address-fields input').forEach(field => {
            field.required = false;
        });
    } else {
        pickupFields.style.display = 'none';
        deliveryFields.style.display = 'block';
        // Toggle required fields
        document.querySelectorAll('#pickup-location-fields input, #pickup-location-fields select').forEach(field => {
            field.required = false;
        });
        document.querySelectorAll('#delivery-address-fields input').forEach(field => {
            field.required = true;
        });
    }
}

// Initialize cart
document.addEventListener('DOMContentLoaded', function() {
    // Load cart from storage
    cart.loadFromStorage();
    
    // Add to cart button listeners
    document.addEventListener('click', function(e) {
        if (e.target.matches('.add-to-cart')) {
            const productCard = e.target.closest('.product-card');
            if (productCard) {
                const id = e.target.dataset.product;
                const name = productCard.querySelector('h3').textContent;
                const priceText = productCard.querySelector('.price').textContent;
                const price = parseFloat(priceText.replace(/[^0-9.]/g, ''));
                
                cart.addItem(id, name, price);
            }
        }
    });
    
    // Quantity control listeners
    document.addEventListener('click', function(e) {
        if (e.target.matches('.quantity-decrease, .quantity-increase')) {
            const id = e.target.dataset.id;
            const currentQty = cart.items[id]?.quantity || 0;
            const newQty = e.target.matches('.quantity-decrease') ? currentQty - 1 : currentQty + 1;
            cart.updateQuantity(id, newQty);
        }
    });
    
    // Remove item listeners
    document.addEventListener('click', function(e) {
        if (e.target.matches('.remove-item')) {
            const id = e.target.dataset.id;
            cart.removeItem(id);
        }
    });
    
    // Quantity input change listener
    document.addEventListener('change', function(e) {
        if (e.target.matches('.quantity-input')) {
            const id = e.target.dataset.id;
            const quantity = parseInt(e.target.value) || 0;
            cart.updateQuantity(id, quantity);
        }
    });

    // Order type toggle listener
    document.querySelectorAll('input[name="order_type"]').forEach(radio => {
        radio.addEventListener('change', toggleDeliveryFields);
    });

    // Initialize form fields visibility
    toggleDeliveryFields();

    // Form submission
    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        orderForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate cart has items
            if (Object.keys(cart.items).length === 0) {
                cart.showNotification('Please add items to your cart before submitting');
                return;
            }

            // Get form data
            const formData = new FormData(this);
            
            // Add cart items to form data
            formData.append('cart_items', JSON.stringify(cart.items));
            
            // Show loading state
            const submitButton = this.querySelector('.submit-order');
            const originalText = submitButton.textContent;
            submitButton.disabled = true;
            submitButton.textContent = 'Processing...';

            // Here you would typically send the data to your server
            // For now, just show a success message
            setTimeout(() => {
                cart.showNotification('Order submitted successfully! Check your email for payment instructions.');
                submitButton.disabled = false;
                submitButton.textContent = originalText;
                // Clear cart
                cart.items = {};
                cart.saveToStorage();
                cart.updateUI();
                // Reset form
                orderForm.reset();
            }, 1500);
        });
    }
});
