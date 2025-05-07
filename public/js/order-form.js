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
      const serviceId = 'YOUR_EMAILJS_SERVICE_ID';
      const customerTemplateId = 'YOUR_CUSTOMER_TEMPLATE_ID';
      const adminTemplateId = 'YOUR_ADMIN_TEMPLATE_ID';
      const userId = 'YOUR_EMAILJS_USER_ID';
      
      // Prepare template parameters
      const templateParams = {
        to_email: contactInfo.email,
        to_name: `${contactInfo.firstName} ${contactInfo.lastName}`,
        order_number: orderNumber,
        order_details: formatOrderDetails(),
        delivery_method: deliveryMethod,
        delivery_info: formatDeliveryInfo(),
        total_amount: calculateTotal().toFixed(2),
        venmo_username: '@your-bakery-venmo'
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
    const newOrderNumber = 'BRD-' + Math.floor(100000 + Math.random() * 900000);
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
          <p>Please send payment via Venmo to @your-bakery-venmo</p>
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
          <h1>Artisan Bread Co.</h1>
          
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
