#!/bin/bash

# Title: Gatita Bakes
# Author/Developer: Bucketbranch
# Version: 1.0.0
# Date: May 7, 2025
#
# This script sets up the Gatita Bakes React application

# Print colored text
print_color() {
  case $1 in
    "green") echo -e "\033[0;32m$2\033[0m" ;;
    "blue") echo -e "\033[0;34m$2\033[0m" ;;
    "red") echo -e "\033[0;31m$2\033[0m" ;;
    "yellow") echo -e "\033[0;33m$2\033[0m" ;;
    *) echo "$2" ;;
  esac
}

# Display header
print_color "blue" "======================================================="
print_color "blue" "   Gatita Bakes - React Application Setup"
print_color "blue" "   Author/Developer: Bucketbranch"
print_color "blue" "   Version: 1.0.0"
print_color "blue" "   Date: May 7, 2025"
print_color "blue" "======================================================="
echo ""

# Check if Node.js is installed
if ! command -v node &> /dev/null || ! command -v npm &> /dev/null; then
    print_color "red" "Error: Node.js and npm are required but not installed."
    print_color "yellow" "Please install Node.js from https://nodejs.org/"
    exit 1
fi

print_color "green" "✓ Node.js is installed"
echo "Node version: $(node -v)"
echo "NPM version: $(npm -v)"
echo ""

# Create React App
print_color "blue" "Step 1: Creating React Application..."
npx create-react-app gatita-bakes
if [ $? -ne 0 ]; then
    print_color "red" "Error: Failed to create React application."
    exit 1
fi
print_color "green" "✓ React application created successfully"
echo ""

# Change to the project directory
cd gatita-bakes
print_color "blue" "Step 2: Installing additional dependencies..."
npm install emailjs-com lucide-react react-router-dom
if [ $? -ne 0 ]; then
    print_color "red" "Error: Failed to install dependencies."
    exit 1
fi
print_color "green" "✓ Dependencies installed successfully"
echo ""

# Create directory structure
print_color "blue" "Step 3: Creating directory structure..."
mkdir -p src/components
print_color "green" "✓ Directory structure created"
echo ""

# Create App.js
print_color "blue" "Step 4: Creating App.js..."
cat > src/App.js << 'EOL'
// src/App.js
/**
 * Title: Gatita Bakes
 * Author/Developer: Bucketbranch
 * Version: 1.0.0
 * Date: May 7, 2025
 */

import React from 'react';
import BreadOrderForm from './components/BreadOrderForm';
import './App.css';

function App() {
  return (
    <div className="App">
      <BreadOrderForm />
    </div>
  );
}

export default App;
EOL
print_color "green" "✓ App.js created"
echo ""

# Create BreadOrderForm.js
print_color "blue" "Step 5: Creating BreadOrderForm.js..."
cat > src/components/BreadOrderForm.js << 'EOL'
// src/components/BreadOrderForm.js
/**
 * Title: Gatita Bakes
 * Author/Developer: Bucketbranch
 * Version: 1.0.0
 * Date: May 7, 2025
 * 
 * Description: Main component for the artisan bread ordering system
 * with cart functionality, order forms, and email integration.
 */

import React, { useState } from 'react';
import { ChevronLeft, ChevronRight, ShoppingCart, X } from 'lucide-react';
import emailjs from 'emailjs-com';
import './BreadOrderForm.css';

const BreadOrderForm = () => {
  // Bread products by category
  const breadCategories = [
    {
      id: 'sourdough',
      name: 'Our Artisan Collection',
      products: [
        { 
          id: 'classic-sourdough', 
          name: 'Everything Sourdough Loaf', 
          price: 8.50, 
          image: '/bread1.jpg', 
          description: 'Crusted with a savory blend of everything seasoning' 
        },
        { 
          id: 'olive-sourdough', 
          name: 'Specialty Sourdough', 
          price: 10.00, 
          image: '/bread2.jpg', 
          description: 'Ask about our rotating specialty bread' 
        },
        { 
          id: 'plain-bagels', 
          name: 'Plain Bagels (Set of 4)', 
          price: 8.00, 
          image: '/bread3.jpg', 
          description: 'Traditional chewy bagels, perfect for toasting' 
        }
      ]
    },
    {
      id: 'artisan',
      name: 'Artisan Loaves',
      products: [
        { 
          id: 'ciabatta', 
          name: 'Ciabatta', 
          price: 7.00, 
          image: '/bread4.jpg', 
          description: 'Italian bread with a light, airy texture' 
        },
        { 
          id: 'baguette', 
          name: 'Baguette', 
          price: 5.50, 
          image: '/bread5.jpg', 
          description: 'Traditional French bread with a crispy crust' 
        },
        { 
          id: 'focaccia', 
          name: 'Focaccia', 
          price: 8.00, 
          image: '/bread6.jpg', 
          description: 'Italian flatbread with rosemary and olive oil' 
        }
      ]
    }
  ];

  // State
  const [currentCategory, setCurrentCategory] = useState(0);
  const [cart, setCart] = useState({});
  const [showCart, setShowCart] = useState(false);
  const [step, setStep] = useState(1); // 1: Products, 2: Contact, 3: Pickup/Delivery, 4: Confirmation
  const [contactInfo, setContactInfo] = useState({
    firstName: '',
    lastName: '',
    email: '',
    phone: ''
  });
  const [deliveryMethod, setDeliveryMethod] = useState('pickup');
  const [deliveryInfo, setDeliveryInfo] = useState({
    street: '',
    city: '',
    zipCode: '',
    notes: ''
  });
  const [pickupLocation, setPickupLocation] = useState('main');
  const [isSubmitted, setIsSubmitted] = useState(false);
  const [orderNumber, setOrderNumber] = useState('');
  const [isEmailSending, setIsEmailSending] = useState(false);
  const [emailError, setEmailError] = useState(null);

  // Calculate cart total
  const calculateTotal = () => {
    return Object.keys(cart).reduce((total, productId) => {
      const item = findProductById(productId);
      return total + (item ? item.price * cart[productId] : 0);
    }, 0);
  };

  // Find a product by ID
  const findProductById = (productId) => {
    for (const category of breadCategories) {
      const product = category.products.find(p => p.id === productId);
      if (product) return product;
    }
    return null;
  };

  // Handle category navigation
  const nextCategory = () => {
    setCurrentCategory((prev) => (prev + 1) % breadCategories.length);
  };

  const prevCategory = () => {
    setCurrentCategory((prev) => (prev - 1 + breadCategories.length) % breadCategories.length);
  };

  // Cart operations
  const addToCart = (productId) => {
    setCart(prevCart => ({
      ...prevCart,
      [productId]: (prevCart[productId] || 0) + 1
    }));
  };

  const removeFromCart = (productId) => {
    setCart(prevCart => {
      const newCart = { ...prevCart };
      if (newCart[productId] > 1) {
        newCart[productId] -= 1;
      } else {
        delete newCart[productId];
      }
      return newCart;
    });
  };

  const updateQuantity = (productId, quantity) => {
    const intQuantity = parseInt(quantity, 10);
    if (isNaN(intQuantity) || intQuantity < 0) return;
    
    setCart(prevCart => {
      const newCart = { ...prevCart };
      if (intQuantity === 0) {
        delete newCart[productId];
      } else {
        newCart[productId] = intQuantity;
      }
      return newCart;
    });
  };

  // Form handlers
  const handleContactChange = (e) => {
    const { name, value } = e.target;
    setContactInfo(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleDeliveryChange = (e) => {
    const { name, value } = e.target;
    setDeliveryInfo(prev => ({
      ...prev,
      [name]: value
    }));
  };

  // Validation
  const canProceedToDelivery = () => {
    const { firstName, lastName, email, phone } = contactInfo;
    return firstName && lastName && email && phone;
  };

  const canPlaceOrder = () => {
    if (deliveryMethod === 'delivery') {
      const { street, city, zipCode } = deliveryInfo;
      return street && city && zipCode;
    }
    return true; // For pickup, no additional validation needed
  };

  // Format order details for email
  const formatOrderDetails = () => {
    let orderDetails = '';
    
    // Add product details
    Object.keys(cart).forEach(productId => {
      const product = findProductById(productId);
      if (product) {
        orderDetails += `${product.name} x ${cart[productId]} - $${(product.price * cart[productId]).toFixed(2)}\n`;
      }
    });
    
    // Add total
    orderDetails += `\nTotal: $${calculateTotal().toFixed(2)}`;
    
    return orderDetails;
  };

  // Format delivery/pickup info
  const formatDeliveryInfo = () => {
    if (deliveryMethod === 'pickup') {
      let location = '';
      if (pickupLocation === 'main') location = 'Main Bakery (123 Bread St)';
      else if (pickupLocation === 'downtown') location = 'Downtown Location (456 Main St)';
      else if (pickupLocation === 'farmers') location = 'Farmers Market (Saturday Only)';
      
      return `Pickup Location: ${location}\n${deliveryInfo.notes ? `Notes: ${deliveryInfo.notes}` : ''}`;
    } else {
      return `Delivery Address: ${deliveryInfo.street}, ${deliveryInfo.city}, ${deliveryInfo.zipCode}\n${deliveryInfo.notes ? `Notes: ${deliveryInfo.notes}` : ''}`;
    }
  };

  // Send order confirmation emails
  const sendOrderEmails = async () => {
    setIsEmailSending(true);
    setEmailError(null);
    
    try {
      // Replace these with your actual EmailJS service ID, template ID, and user ID
      const serviceId = process.env.REACT_APP_EMAILJS_SERVICE_ID || 'YOUR_EMAILJS_SERVICE_ID';
      const customerTemplateId = process.env.REACT_APP_EMAILJS_CUSTOMER_TEMPLATE_ID || 'YOUR_CUSTOMER_TEMPLATE_ID';
      const adminTemplateId = process.env.REACT_APP_EMAILJS_ADMIN_TEMPLATE_ID || 'YOUR_ADMIN_TEMPLATE_ID';
      const userId = process.env.REACT_APP_EMAILJS_USER_ID || 'YOUR_EMAILJS_USER_ID';
      
      // Prepare template parameters
      const templateParams = {
        to_email: contactInfo.email,
        to_name: `${contactInfo.firstName} ${contactInfo.lastName}`,
        order_number: orderNumber,
        order_details: formatOrderDetails(),
        delivery_method: deliveryMethod,
        delivery_info: formatDeliveryInfo(),
        total_amount: calculateTotal().toFixed(2),
        venmo_username: '@gatita-bakes'
      };
      
      // Send email to customer
      await emailjs.send(serviceId, customerTemplateId, templateParams, userId);
      
      // Send email to admin
      const adminTemplateParams = {
        ...templateParams,
        customer_phone: contactInfo.phone,
        customer_email: contactInfo.email
      };
      
      await emailjs.send(serviceId, adminTemplateId, adminTemplateParams, userId);
      
    } catch (error) {
      console.error('Failed to send email:', error);
      setEmailError('Failed to send confirmation email. Please contact us directly.');
    } finally {
      setIsEmailSending(false);
    }
  };

  // Order submission
  const handleSubmit = (e) => {
    e.preventDefault();
    
    // Generate random order number
    const newOrderNumber = 'GBK-' + Math.floor(100000 + Math.random() * 900000);
    setOrderNumber(newOrderNumber);
    
    // Send confirmation emails
    sendOrderEmails();
    
    // Mark order as submitted
    setIsSubmitted(true);
  };

  // Cart item count for badge
  const itemCount = Object.values(cart).reduce((sum, quantity) => sum + quantity, 0);

  // UI Components
  const renderProductCards = () => {
    const currentProducts = breadCategories[currentCategory].products;
    
    return (
      <div className="product-grid">
        {currentProducts.map(product => (
          <div key={product.id} className="product-card">
            <img 
              src={product.image} 
              alt={product.name} 
              className="product-image"
              onError={(e) => {
                e.target.onerror = null;
                e.target.src = 'https://via.placeholder.com/250x250?text=Bread+Image';
              }}
            />
            <div className="product-info">
              <h3 className="product-name">{product.name}</h3>
              <p className="product-description">{product.description}</p>
              <p className="product-price">${product.price.toFixed(2)}</p>
              
              {cart[product.id] ? (
                <div className="quantity-control">
                  <button 
                    onClick={() => removeFromCart(product.id)}
                    className="quantity-btn minus"
                  >
                    -
                  </button>
                  <input 
                    type="number" 
                    min="0" 
                    value={cart[product.id]} 
                    onChange={(e) => updateQuantity(product.id, e.target.value)}
                    className="quantity-input"
                  />
                  <button 
                    onClick={() => addToCart(product.id)}
                    className="quantity-btn plus"
                  >
                    +
                  </button>
                </div>
              ) : (
                <button 
                  onClick={() => addToCart(product.id)}
                  className="add-to-cart-btn"
                >
                  Add to Cart
                </button>
              )}
            </div>
          </div>
        ))}
      </div>
    );
  };

  const renderCart = () => {
    return (
      <div className="cart-overlay">
        <div className="cart-container">
          <div className="cart-header">
            <h2>Your Cart</h2>
            <button 
              onClick={() => setShowCart(false)}
              className="close-btn"
            >
              <X size={24} />
            </button>
          </div>
          
          {Object.keys(cart).length === 0 ? (
            <div className="empty-cart">
              Your cart is empty
            </div>
          ) : (
            <>
              <div className="cart-summary">
                <h3>Order Summary</h3>
                <div className="cart-summary-info">
                  {Object.keys(cart).length} {Object.keys(cart).length === 1 ? 'item' : 'items'} selected
                </div>
              </div>
              
              <ul className="cart-items">
                {Object.keys(cart).map(productId => {
                  const product = findProductById(productId);
                  if (!product) return null;
                  
                  return (
                    <li key={productId} className="cart-item">
                      <img 
                        src={product.image} 
                        alt={product.name}
                        className="cart-item-image"
                        onError={(e) => {
                          e.target.onerror = null;
                          e.target.src = 'https://via.placeholder.com/80x80?text=Bread';
                        }}
                      />
                      <div className="cart-item-info">
                        <h3>{product.name}</h3>
                        <p>${product.price.toFixed(2)}</p>
                      </div>
                      <div className="cart-item-quantity">
                        <button 
                          onClick={() => removeFromCart(productId)}
                          className="quantity-btn minus"
                        >
                          -
                        </button>
                        <input 
                          type="number" 
                          min="0" 
                          value={cart[productId]} 
                          onChange={(e) => updateQuantity(productId, e.target.value)}
                          className="quantity-input"
                        />
                        <button 
                          onClick={() => addToCart(productId)}
                          className="quantity-btn plus"
                        >
                          +
                        </button>
                      </div>
                    </li>
                  );
                })}
              </ul>
              
              <div className="cart-footer">
                <div className="cart-total">
                  <span>Total:</span>
                  <span>${calculateTotal().toFixed(2)}</span>
                </div>
                
                <button 
                  onClick={() => {
                    setShowCart(false);
                    setStep(2);
                  }}
                  className="checkout-btn"
                >
                  Proceed to Checkout
                </button>
              </div>
            </>
          )}
        </div>
      </div>
    );
  };

  const renderContactForm = () => {
    return (
      <div className="form-container">
        <h2>Contact Information</h2>
        
        <div className="form-fields">
          <div className="form-row">
            <div className="form-field">
              <label htmlFor="firstName">
                First Name <span className="required">*</span>
              </label>
              <input
                type="text"
                id="firstName"
                name="firstName"
                value={contactInfo.firstName}
                onChange={handleContactChange}
                required
              />
            </div>
            <div className="form-field">
              <label htmlFor="lastName">
                Last Name <span className="required">*</span>
              </label>
              <input
                type="text"
                id="lastName"
                name="lastName"
                value={contactInfo.lastName}
                onChange={handleContactChange}
                required
              />
            </div>
          </div>
          
          <div className="form-field">
            <label htmlFor="email">
              Email <span className="required">*</span>
            </label>
            <input
              type="email"
              id="email"
              name="email"
              value={contactInfo.email}
              onChange={handleContactChange}
              required
            />
          </div>
          
          <div className="form-field">
            <label htmlFor="phone">
              Phone <span className="required">*</span>
            </label>
            <input
              type="tel"
              id="phone"
              name="phone"
              value={contactInfo.phone}
              onChange={handleContactChange}
              required
            />
          </div>
        </div>
        
        <div className="form-buttons">
          <button
            onClick={() => setStep(1)}
            className="back-btn"
          >
            Back
          </button>
          
          <button
            onClick={() => setStep(3)}
            disabled={!canProceedToDelivery()}
            className={`continue-btn ${!canProceedToDelivery() ? 'disabled' : ''}`}
          >
            Continue
          </button>
        </div>
      </div>
    );
  };

  const renderDeliveryForm = () => {
    return (
      <div className="form-container">
        <h2>Order Type</h2>
        
        <div className="delivery-method">
          <label className="method-option">
            <input
              type="radio"
              name="deliveryMethod"
              value="pickup"
              checked={deliveryMethod === 'pickup'}
              onChange={() => setDeliveryMethod('pickup')}
            />
            Pickup
          </label>
          
          <label className="method-option">
            <input
              type="radio"
              name="deliveryMethod"
              value="delivery"
              checked={deliveryMethod === 'delivery'}
              onChange={() => setDeliveryMethod('delivery')}
            />
            Delivery
          </label>
        </div>
        
        {deliveryMethod === 'pickup' ? (
          <div className="pickup-form">
            <h3>Pickup Location</h3>
            <select
              value={pickupLocation}
              onChange={(e) => setPickupLocation(e.target.value)}
              className="pickup-select"
            >
              <option value="main">Main Bakery (123 Bread St)</option>
              <option value="downtown">Downtown Location (456 Main St)</option>
              <option value="farmers">Farmers Market (Saturday Only)</option>
            </select>
            
            <div className="form-field">
              <label htmlFor="pickupNotes">Special Instructions</label>
              <textarea
                name="notes"
                id="pickupNotes"
                value={deliveryInfo.notes}
                onChange={handleDeliveryChange}
                rows="3"
                placeholder="Any special pickup instructions"
              ></textarea>
            </div>
          </div>
        ) : (
          <div className="delivery-form">
            <h3>Delivery Address</h3>
            <div className="form-field">
              <label htmlFor="street">
                Street Address <span className="required">*</span>
              </label>
              <input
                type="text"
                id="street"
                name="street"
                value={deliveryInfo.street}
                onChange={handleDeliveryChange}
                required
              />
            </div>
            
            <div className="form-row">
              <div className="form-field">
                <label htmlFor="city">
                  City <span className="required">*</span>
                </label>
                <input
                  type="text"
                  id="city"
                  name="city"
                  value={deliveryInfo.city}
                  onChange={handleDeliveryChange}
                  required
                />
              </div>
              
              <div className="form-field">
                <label htmlFor="zipCode">
                  ZIP Code <span className="required">*</span>
                </label>
                <input
                  type="text"
                  id="zipCode"
                  name="zipCode"
                  value={deliveryInfo.zipCode}
                  onChange={handleDeliveryChange}
                  required
                />
              </div>
            </div>
            
            <div className="form-field">
              <label htmlFor="deliveryNotes">Delivery Notes</label>
              <textarea
                name="notes"
                id="deliveryNotes"
                value={deliveryInfo.notes}
                onChange={handleDeliveryChange}
                rows="3"
                placeholder="Apartment number, gate code, etc."
              ></textarea>
            </div>
          </div>
        )}
        
        <div className="form-buttons">
          <button
            onClick={() => setStep(2)}
            className="back-btn"
          >
            Back
          </button>
          
          <button
            onClick={handleSubmit}
            disabled={!canPlaceOrder()}
            className={`continue-btn ${!canPlaceOrder() ? 'disabled' : ''}`}
          >
            Place Order
          </button>
        </div>
      </div>
    );
  };

  const renderOrderConfirmation = () => {
    return (
      <div className="confirmation-container">
        <div className="confirmation-header">
          <div className="confirmation-icon">
            <svg xmlns="http://www.w3.org/2000/svg" className="check-icon" viewBox="0 0 24 24" stroke="currentColor" fill="none">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h2>Thank You for Your Order!</h2>
          <p>Order #{orderNumber}</p>
        </div>
        
        <div className="confirmation-section">
          <h3>Order Summary</h3>
          <ul className="confirmation-items">
            {Object.keys(cart).map(productId => {
              const product = findProductById(productId);
              if (!product) return null;
              
              return (
                <li key={productId} className="confirmation-item">
                  <img 
                    src={product.image} 
                    alt={product.name}
                    className="confirmation-item-image"
                    onError={(e) => {
                      e.target.onerror = null;
                      e.target.src = 'https://via.placeholder.com/80x80?text=Bread';
                    }}
                  />
                  <div className="confirmation-item-details">
                    <p className="item-name">{product.name}</p>
                    <p className="item-price">${product.price.toFixed(2)} × {cart[productId]}</p>
                  </div>
                  <span className="item-total">${(product.price * cart[productId]).toFixed(2)}</span>
                </li>
              );
            })}
          </ul>
          <div className="confirmation-total">
            <span>Total:</span>
            <span>${calculateTotal().toFixed(2)}</span>
          </div>
        </div>
        
        <div className="confirmation-section">
          <h3>Payment Instructions</h3>
          <p>Please send payment via Venmo to @gatita-bakes</p>
          <p className="payment-note">Include your order number ({orderNumber}) in the payment notes.</p>
        </div>
        
        <div className="confirmation-section">
          <h3>Order Details</h3>
          <div className="order-details">
            <div className="detail-item">
              <p className="detail-label">Name:</p>
              <p className="detail-value">{contactInfo.firstName} {contactInfo.lastName}</p>
            </div>
            <div className="detail-item">
              <p className="detail-label">Email:</p>
              <p className="detail-value">{contactInfo.email}</p>
            </div>
            <div className="detail-item">
              <p className="detail-label">Phone:</p>
              <p className="detail-value">{contactInfo.phone}</p>
            </div>
            <div className="detail-item">
              <p className="detail-label">Method:</p>
              <p className="detail-value capitalize">{deliveryMethod}</p>
            </div>
          </div>
          
          <div className="detail-delivery">
            {deliveryMethod === 'pickup' ? (
              <div>
                <p className="detail-label">Pickup Location:</p>
                <p className="detail-value">
                  {pickupLocation === 'main' && 'Main Bakery (123 Bread St)'}
                  {pickupLocation === 'downtown' && 'Downtown Location (456 Main St)'}
                  {pickupLocation === 'farmers' && 'Farmers Market (Saturday Only)'}
                </p>
                {deliveryInfo.notes && (
                  <div className="mt-2">
                    <p className="detail-label">Notes:</p>
                    <p className="detail-value">{deliveryInfo.notes}</p>
                  </div>
                )}
              </div>
            ) : (
              <div>
                <p className="detail-label">Delivery Address:</p>
                <p className="detail-value">
                  {deliveryInfo.street}, {deliveryInfo.city}, {deliveryInfo.zipCode}
                </p>
                {deliveryInfo.notes && (
                  <div>
                    <p className="detail-label">Notes:</p>
                    <p className="detail-value">{deliveryInfo.notes}</p>
                  </div>
                )}
              </div>
            )}
          </div>
        </div>
        
        {emailError && (
          <div className="email-error">
            {emailError}
          </div>
        )}
        
        <div className="confirmation-footer">
          <p className="confirmation-message">A confirmation email has been sent to your email address.</p>
          <button
            onClick={() => {
              setCart({});
              setContactInfo({ firstName: '', lastName: '', email: '', phone: '' });
              setDeliveryInfo({ street: '', city: '', zipCode: '', notes: '' });
              setDeliveryMethod('pickup');
              setPickupLocation('main');
              setStep(1);
              setIsSubmitted(false);
              setEmailError(null);
            }}
            className="new-order-btn"
          >
            Place Another Order
          </button>
        </div>
      </div>
    );
  };

  // Main render
  return (
    <div className="bread-order-form">
      {/* Header */}
      <header className="header">
        <div className="header-container">
          <h1>Gatita Bakes</h1>
          
          {step === 1 && (
            <button
              onClick={() => setShowCart(true)}
              className="cart-btn"
            >
              <ShoppingCart size={24} />
              {itemCount > 0 && (
                <span className="cart-badge">
                  {itemCount}
                </span>
              )}
            </button>
          )}
        </div>
      </header>

      {/* Main content based on step */}
      <main className="main-content">
        {!isSubmitted ? (
          <>
            {/* Progress indicator */}
            {step > 1 && (
              <div className="progress-bar">
                <div className="progress-steps">
                  <div className={`progress-step ${step >= 1 ? 'active' : ''}`}>
                    1
                  </div>
                  <div className={`progress-line ${step >= 2 ? 'active' : ''}`}></div>
                  <div className={`progress-step ${step >= 2 ? 'active' : ''}`}>
                    2
                  </div>
                  <div className={`progress-line ${step >= 3 ? 'active' : ''}`}></div>
                  <div className={`progress-step ${step >= 3 ? 'active' : ''}`}>
                    3
                  </div>
                </div>
                <div className="progress-labels">
                  <span>Products</span>
                  <span>Contact</span>
                  <span>Order Type</span>
                </div>
              </div>
            )}

            {/* Step 1: Product Selection */}
            {step === 1 && (
              <>
                <div className="product-section">
                  <h2 className="section-title">Our Artisan Collection</h2>
                  
                  {/* Category Selection */}
                  <div className="category-navigation">
                    <button 
                      onClick={prevCategory}
                      className="nav-btn"
                    >
                      <ChevronLeft size={20} />
                    </button>
                    
                    <h3 className="category-title">
                      {breadCategories[currentCategory].name}
                    </h3>
                    
                    <button 
                      onClick={nextCategory}
                      className="nav-btn"
                    >
                      <ChevronRight size={20} />
                    </button>
                  </div>
                  
                  {/* Product Cards */}
                  {renderProductCards()}
                </div>
                
                {/* Cart drawer */}
                {showCart && renderCart()}
                
                {/* Fixed proceed button */}
                {Object.keys(cart).length > 0 && !showCart && (
                  <div className="checkout-bar">
                    <div className="checkout-container">
                      <div className="checkout-summary">
                        <p className="checkout-count">{itemCount} {itemCount === 1 ? 'item' : 'items'}</p>
                        <p className="checkout-total">${calculateTotal().toFixed(2)}</p>
                      </div>
                      <button 
                        onClick={() => setStep(2)}
                        className="proceed-btn"
                      >
                        Proceed to Checkout
                      </button>
                    </div>
                  </div>
                )}
              </>
            )}

            {/* Step 2: Contact Info */}
            {step === 2 && renderContactForm()}

            {/* Step 3: Delivery/Pickup */}
            {step === 3 && renderDeliveryForm()}
          </>
        ) : (
          /* Order Confirmation */
          renderOrderConfirmation()
        )}
      </main>
      
      {/* Information Section */}
      <div className="info-section">
        <div className="info-container">
          <h2>Note: Product Spotlight</h2>
          <p>
            Here will go text instructions to pay and product spotlight for deals
          </p>
          
          <div className="email-info">
            <h3>Two Emails are generated:</h3>
            <ol className="email-list">
              <li>One to the customer with what they ordered and payment link to Venmo with instructions</li>
              <li>Second email to bakery backend announcing the order with a link to check payment status</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  );
};

export default BreadOrderForm;
EOL
print_color "green" "✓ BreadOrderForm.js created"
echo ""

# Create BreadOrderForm.css
print_color "blue" "Step 6: Creating BreadOrderForm.css..."
cat > src/components/BreadOrderForm.css << 'EOL'
/* src/components/BreadOrderForm.css */
/**
 * Title: Gatita Bakes
 * Author/Developer: Bucketbranch
 * Version: 1.0.0
 * Date: May 7, 2025
 * 
 * Styles for the artisan bread ordering component
 */

/* General Styles */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  line-height: 1.6;
  color: #333;
  background-color: #faf6f0;
}

.bread-order-form {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 15px;
}

/* Header */
.header {
  background-color: #8b4513;
  color: white;
  padding: 1rem;
  position: sticky;
  top: 0;
  z-index: 30;
}

.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 15px;
}

.cart-btn {
  background: none;
  border: none;
  color: white;
  cursor: pointer;
  position: relative;
}

.cart-badge {
  position: absolute;
  top: -8px;
  right: -8px;
  background-color: #e74c3c;
  color: white;
  font-size: 12px;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Main Content */
.main-content {
  flex: 1;
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem 15px;
  width: 100%;
}

/* Progress Bar */
.progress-bar {
  margin-bottom: 2rem;
}

.progress-steps {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.progress-step {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background-color: #e0e0e0;
  color: #666;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
}

.progress-step.active {
  background-color: #8b4513;
  color: white;
}

.progress-line {
  flex-grow: 1;
  height: 4px;
  background-color: #e0e0e0;
  margin: 0 10px;
}

.progress-line.active {
  background-color: #8b4513;
}

.progress-labels {
  display: flex;
  justify-content: space-between;
  margin-top: 8px;
  font-size: 14px;
  color: #666;
}

/* Product Section */
.section-title {
  text-align: center;
  margin-bottom: 1.5rem;
  color: #333;
  font-size: 2rem;
}

.category-navigation {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.category-title {
  font-size: 1.5rem;
  color: #333;
}

.nav-btn {
  background-color: #8b4513;
  color: white;
  border: none;
  border-radius: 50%;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background-color 0.2s;
}

.nav-btn:hover {
  background-color: #6d370f;
}

/* Product Grid */
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2rem;
  margin-top: 2rem;
}

.product-card {
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s, box-shadow 0.2s;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.product-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.product-info {
  padding: 1.5rem;
}

.product-name {
  font-size: 1.2rem;
  margin-bottom: 0.5rem;
  color: #333;
}

.product-description {
  color: #666;
  margin-bottom: 1rem;
  font-size: 0.9rem;
}

.product-price {
  color: #8b4513;
  font-weight: bold;
  font-size: 1.1rem;
  margin-bottom: 1rem;
}

.add-to-cart-btn {
  width: 100%;
  padding: 0.75rem;
  background-color: #8b4513;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
  font-weight: 600;
}

.add-to-cart-btn:hover {
  background-color: #6d370f;
}

.quantity-control {
  display: flex;
  align-items: center;
}

.quantity-btn {
  width: 32px;
  height: 32px;
  background-color: #f0e6d4;
  color: #8b4513;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 1.2rem;
  font-weight: bold;
}

.quantity-btn.minus {
  border-radius: 4px 0 0 4px;
}

.quantity-btn.plus {
  border-radius: 0 4px 4px 0;
}

.quantity-input {
  width: 50px;
  height: 32px;
  border: 1px solid #f0e6d4;
  text-align: center;
  font-size: 1rem;
}

/* Cart Overlay */
.cart-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 40;
  display: flex;
  justify-content: flex-end;
}

.cart-container {
  background-color: white;
  width: 100%;
  max-width: 450px;
  height: 100%;
  overflow: auto;
  display: flex;
  flex-direction: column;
}

.cart-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  border-bottom: 1px solid #eee;
}

.close-btn {
  background: none;
  border: none;
  color: #666;
  cursor: pointer;
}

.empty-cart {
  padding: 3rem 1rem;
  text-align: center;
  color: #666;
  font-style: italic;
}

.cart-summary {
  padding: 1rem;
  background-color: #f8f3e8;
}

.cart-summary-info {
  font-size: 0.9rem;
  color: #666;
  margin-top: 0.5rem;
}

.cart-items {
  list-style: none;
  flex: 1;
}

.cart-item {
  display: flex;
  padding: 1rem;
  border-bottom: 1px solid #eee;
  align-items: center;
}

.cart-item-image {
  width: 64px;
  height: 64px;
  object-fit: cover;
  border-radius: 4px;
  margin-right: 1rem;
}

.cart-item-info {
  flex: 1;
}

.cart-item-info h3 {
  font-size: 1rem;
  margin-bottom: 0.25rem;
}

.cart-item-info p {
  color: #8b4513;
  font-weight: 600;
}

.cart-item-quantity {
  display: flex;
  align-items: center;
}

.cart-footer {
  padding: 1rem;
  border-top: 1px solid #eee;
}

.cart-total {
  display: flex;
  justify-content: space-between;
  font-size: 1.2rem;
  font-weight: bold;
  margin-bottom: 1rem;
}

.checkout-btn {
  width: 100%;
  padding: 0.75rem;
  background-color: #8b4513;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
  font-weight: 600;
}

.checkout-btn:hover {
  background-color: #6d370f;
}

/* Checkout Bar */
.checkout-bar {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: white;
  padding: 1rem;
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
  z-index: 20;
}

.checkout-container {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.checkout-count {
  font-size: 0.9rem;
  color: #666;
}

.checkout-total {
  font-weight: bold;
  font-size: 1.1rem;
}

.proceed-btn {
  padding: 0.75rem 1.5rem;
  background-color: #8b4513;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
  font-weight: 600;
}

.proceed-btn:hover {
  background-color: #6d370f;
}

/* Form Styles */
.form-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 2rem;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-container h2 {
  margin-bottom: 1.5rem;
  color: #333;
}

.form-fields {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.form-field {
  display: flex;
  flex-direction: column;
}

.form-field label {
  margin-bottom: 0.5rem;
  font-size: 0.9rem;
  color: #555;
}

.required {
  color: #e74c3c;
}

.form-field input,
.form-field textarea,
.form-field select {
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

.form-field textarea {
  min-height: 100px;
  resize: vertical;
}

.form-buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 2rem;
}

.back-btn {
  padding: 0.75rem 1.5rem;
  background-color: #e0e0e0;
  color: #333;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
  font-weight: 600;
}

.back-btn:hover {
  background-color: #d0d0d0;
}

.continue-btn {
  padding: 0.75rem 1.5rem;
  background-color: #8b4513;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
  font-weight: 600;
}

.continue-btn:hover {
  background-color: #6d370f;
}

.continue-btn.disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

/* Delivery Method */
.delivery-method {
  display: flex;
  gap: 2rem;
  margin-bottom: 1.5rem;
}

.method-option {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
}

.pickup-form,
.delivery-form {
  background-color: #f8f3e8;
  padding: 1.5rem;
  border-radius: 8px;
  margin-bottom: 1.5rem;
}

.pickup-form h3,
.delivery-form h3 {
  margin-bottom: 1rem;
  color: #333;
}

.pickup-select {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
  margin-bottom: 1rem;
}

/* Confirmation Styles */
.confirmation-container {
  max-width: 700px;
  margin: 0 auto;
  padding: 2rem;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.confirmation-header {
  text-align: center;
  margin-bottom: 2rem;
}

.confirmation-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 64px;
  height: 64px;
  background-color: #e6f7e6;
  border-radius: 50%;
  margin-bottom: 1rem;
}

.check-icon {
  width: 32px;
  height: 32px;
  color: #2ecc71;
}

.confirmation-header h2 {
  margin-bottom: 0.5rem;
  color: #333;
}

.confirmation-header p {
  color: #666;
}

.confirmation-section {
  background-color: #f8f3e8;
  border-radius: 8px;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
}

.confirmation-section h3 {
  font-size: 1.1rem;
  margin-bottom: 1rem;
  color: #333;
}

.confirmation-items {
  list-style: none;
}

.confirmation-item {
  display: flex;
  padding: 0.75rem 0;
  border-bottom: 1px solid #e0e0e0;
  align-items: center;
}

.confirmation-item:last-child {
  border-bottom: none;
}

.confirmation-item-image {
  width: 64px;
  height: 64px;
  object-fit: cover;
  border-radius: 4px;
  margin-right: 1rem;
}

.confirmation-item-details {
  flex: 1;
}

.item-name {
  font-weight: 600;
}

.item-price {
  font-size: 0.9rem;
  color: #666;
}

.item-total {
  font-weight: 600;
}

.confirmation-total {
  display: flex;
  justify-content: space-between;
  font-weight: bold;
  padding-top: 1rem;
  border-top: 1px solid #e0e0e0;
  margin-top: 0.5rem;
}

.payment-note {
  font-size: 0.9rem;
  color: #666;
  margin-top: 0.5rem;
}

.order-details {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.detail-item {
  margin-bottom: 0.5rem;
}

.detail-label {
  font-size: 0.9rem;
  color: #666;
  margin-bottom: 0.25rem;
}

.detail-value {
  font-weight: 600;
}

.detail-delivery {
  margin-top: 1rem;
}

.capitalize {
  text-transform: capitalize;
}

.email-error {
  background-color: #fde2e2;
  border-radius: 4px;
  padding: 1rem;
  margin-bottom: 1.5rem;
  color: #e53e3e;
}

.confirmation-footer {
  text-align: center;
}

.confirmation-message {
  color: #666;
  margin-bottom: 1rem;
}

.new-order-btn {
  padding: 0.75rem 1.5rem;
  background-color: #8b4513;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
  font-weight: 600;
}

.new-order-btn:hover {
  background-color: #6d370f;
}

/* Info Section */
.info-section {
  background-color: #f8f3e8;
  padding: 2rem 15px;
  margin-top: 2rem;
}

.info-container {
  max-width: 800px;
  margin: 0 auto;
}

.info-container h2 {
  margin-bottom: 1rem;
  color: #333;
}

.info-container p {
  color: #666;
  margin-bottom: 1.5rem;
}

.email-info h3 {
  margin-bottom: 1rem;
  color: #333;
}

.email-list {
  padding-left: 1.5rem;
  color: #333;
}

.email-list li {
  margin-bottom: 0.5rem;
}

/* Media Queries */
@media (max-width: 768px) {
  .product-grid {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  }

  .form-row {
    grid-template-columns: 1fr;
  }

  .order-details {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 480px) {
  .product-grid {
    grid-template-columns: 1fr;
  }

  .form-container,
  .confirmation-container {
    padding: 1.5rem;
  }

  .cart-container {
    width: 100%;
  }
}
EOL
print_color "green" "✓ BreadOrderForm.css created"
echo ""

# Create .env file
print_color "blue" "Step 7: Creating .env file..."
cat > .env << 'EOL'
# Gatita Bakes Environment Variables
REACT_APP_EMAILJS_USER_ID=your_emailjs_user_id
REACT_APP_EMAILJS_SERVICE_ID=your_emailjs_service_id
REACT_APP_EMAILJS_CUSTOMER_TEMPLATE_ID=your_customer_template_id
REACT_APP_EMAILJS_ADMIN_TEMPLATE_ID=your_admin_template_id
EOL
print_color "green" "✓ .env file created"
echo ""

# Create placeholder images
print_color "blue" "Step 8: Creating placeholder image files..."
mkdir -p public/images
# Create empty placeholder files (in a real environment, you would add actual images)
touch public/bread1.jpg
touch public/bread2.jpg
touch public/bread3.jpg
touch public/bread4.jpg
touch public/bread5.jpg
touch public/bread6.jpg
print_color "green" "✓ Placeholder image files created"
echo ""

# Create .gitignore file to exclude .env
print_color "blue" "Step 9: Creating .gitignore file..."
cat > .gitignore << 'EOL'
# See https://help.github.com/articles/ignoring-files/ for more about ignoring files.

# dependencies
/node_modules
/.pnp
.pnp.js

# testing
/coverage

# production
/build

# misc
.DS_Store
.env
.env.local
.env.development.local
.env.test.local
.env.production.local

npm-debug.log*
yarn-debug.log*
yarn-error.log*
EOL
print_color "green" "✓ .gitignore file created"
echo ""

# Create README.md file
print_color "blue" "Step 10: Creating README.md file..."
cat > README.md << 'EOL'
# Artisan Bread Ordering Application

**Title:** Gatita Bakes  
**Author/Developer:** Bucketbranch  
**Version:** 1.0.0  
**Date:** May 7, 2025

A standalone React application for an artisan bakery to take bread orders online with Venmo payment integration.

## Features

- Mobile-responsive design
- Product carousel for browsing bread offerings
- Shopping cart functionality
- Customer information collection
- Delivery and pickup options
- Order confirmation with Venmo payment instructions
- Email notifications for both customers and administrators

## Getting Started

### Prerequisites

- [Node.js](https://nodejs.org/) (version 14 or higher)
- npm (comes with Node.js)

### Installation

1. Clone this repository or download the ZIP file
2. Navigate to the project directory
3. Install dependencies:

```bash
npm install
```

4. Update the `.env` file in the root directory with your EmailJS keys:

```
REACT_APP_EMAILJS_USER_ID=your_user_id
REACT_APP_EMAILJS_SERVICE_ID=your_service_id
REACT_APP_EMAILJS_CUSTOMER_TEMPLATE_ID=your_customer_template_id
REACT_APP_EMAILJS_ADMIN_TEMPLATE_ID=your_admin_template_id
```

5. Add your product images to the public folder (named bread1.jpg, bread2.jpg, etc.)

6. Start the development server:

```bash
npm start
```

7. Open [http://localhost:3000](http://localhost:3000) to view it in your browser.

## Deployment

To deploy this application to a live server:

1. Build the production version:

```bash
npm run build
```

2. Deploy the contents of the `build` folder to your web hosting service.

For detailed deployment instructions using Netlify, see the included deployment guide.

## Email Integration

This application uses EmailJS to send order confirmation emails. Before going live, make sure to:

1. Sign up for an EmailJS account
2. Create an email service
3. Set up two email templates (customer and admin)
4. Update the `.env` file with your EmailJS credentials

## Customization

To customize the product offerings, update the `breadCategories` array in the `BreadOrderForm.js` file.

To change the Venmo payment information, update the `venmo_username` in the `sendOrderEmails` function.

## License

MIT
EOL
print_color "green" "✓ README.md file created"
echo ""

# Initialize Git repository
print_color "blue" "Step 11: Initializing Git repository..."
git init
git add .
git commit -m "Initial commit - Gatita Bakes application"
print_color "green" "✓ Git repository initialized"
echo ""

# Start development server
print_color "blue" "Step 12: Starting development server..."
print_color "yellow" "Starting the React development server. Press Ctrl+C to stop when you're done."
npm start
