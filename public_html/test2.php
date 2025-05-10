<?php
/**
 * Project: Gatita Bakes Online Order System
 * Title: Test2
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2025-05-10
 */
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>

<main class="order-form-container">
    <div class="form-wrapper">
        <h1 class="form-title">Place Your Order</h1>
        
        <div class="form-frame">
            <form id="order-form" class="multi-step-form">
                <!-- Step 1: Order Type -->
                <div class="form-step active" id="step-1">
                    <h2>Delivery Method</h2>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="delivery_method" value="pickup" required> 
                            <span>Pickup</span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="delivery_method" value="delivery" required>
                            <span>Delivery (+$5)</span>
                        </label>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="nav-btn prev-btn" disabled>Back</button>
                        <button type="button" class="nav-btn next-btn">Continue</button>
                    </div>
                </div>

                <!-- Step 2: Address/Contact -->
                <div class="form-step" id="step-2">
                    <div class="address-section">
                        <div id="pickup-fields" class="address-fields">
                            <h3>Pickup Location</h3>
                            <select class="form-input" required>
                                <option value="">Select location</option>
                                <option value="westsac">West Sacramento</option>
                                <option value="farmersmarket">Farmers Market</option>
                            </select>
                        </div>
                        
                        <div id="delivery-fields" class="address-fields">
                            <h3>Delivery Address</h3>
                            <input type="text" class="form-input" placeholder="Street Address" required>
                            <input type="text" class="form-input" placeholder="Apt/Suite">
                            <div class="city-zip-row">
                                <input type="text" class="form-input" placeholder="City" required>
                                <input type="text" class="form-input" placeholder="ZIP" required pattern="\d{5}">
                            </div>
                        </div>
                        
                        <div class="contact-fields">
                            <h3>Contact Info</h3>
                            <div class="name-row">
                                <input type="text" class="form-input" placeholder="First Name" required>
                                <input type="text" class="form-input" placeholder="Last Name" required>
                            </div>
                            <input type="email" class="form-input" placeholder="Email" required>
                            <input type="tel" class="form-input" placeholder="Phone" required>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="nav-btn prev-btn">Back</button>
                        <button type="button" class="nav-btn next-btn">Continue</button>
                    </div>
                </div>

                <!-- Step 3: Review & Submit -->
                <div class="form-step" id="step-3">
                    <h2>Review Your Order</h2>
                    <div class="order-summary">
                        <!-- Cart items will be dynamically inserted here -->
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="nav-btn prev-btn">Back</button>
                        <button type="submit" class="submit-btn">Place Order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="order-sidebar">
        <h3>Your Order</h3>
        <div class="cart-items">
            <!-- Cart items will appear here -->
        </div>
        <div class="order-total">
            <span>Total:</span>
            <span class="total-amount">$0.00</span>
        </div>
    </div>
</main>

<style>
.order-form-container {
    display: flex;
    max-width: 1200px;
    margin: 2rem auto;
    gap: 2rem;
}

.form-wrapper {
    flex: 2;
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-step {
    display: none;
}

.form-step.active {
    display: block;
}

.address-fields {
    display: none;
    margin-bottom: 1.5rem;
}

.form-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
}

.submit-btn {
    background: #8b4513;
    color: white;
    padding: 0.75rem 2rem;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
}

.order-sidebar {
    flex: 1;
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    align-self: flex-start;
}
</style>

<script>
// Form navigation logic
const steps = document.querySelectorAll('.form-step');
const nextBtns = document.querySelectorAll('.next-btn');
const prevBtns = document.querySelectorAll('.prev-btn');
let currentStep = 0;

// Initialize first step
steps[0].classList.add('active');

// Next button functionality
nextBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        if (validateStep(currentStep)) {
            steps[currentStep].classList.remove('active');
            currentStep++;
            steps[currentStep].classList.add('active');
            updateFormDisplay();
        }
    });
});

// Previous button functionality
prevBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        steps[currentStep].classList.remove('active');
        currentStep--;
        steps[currentStep].classList.add('active');
        updateFormDisplay();
    });
});

// Delivery method toggle
document.querySelectorAll('input[name="delivery_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('pickup-fields').style.display = 
            this.value === 'pickup' ? 'block' : 'none';
        document.getElementById('delivery-fields').style.display = 
            this.value === 'delivery' ? 'block' : 'none';
    });
});

function validateStep(step) {
    // Add validation logic for each step
    return true;
}

function updateFormDisplay() {
    // Update button states based on current step
    prevBtns.forEach(btn => {
        btn.disabled = currentStep === 0;
    });
    
    nextBtns.forEach(btn => {
        btn.textContent = currentStep === steps.length - 2 ? 'Review Order' : 'Continue';
    });
}
</script>

<?php require_once 'includes/footer.php'; ?> 