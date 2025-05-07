// Main JavaScript for Gatita Bakes

document.addEventListener('DOMContentLoaded', function() {
    // Initialize the order form
    initializeOrderForm();
    
    // Setup navigation scroll behavior
    setupNavigation();
});

function initializeOrderForm() {
    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        orderForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleOrderSubmission();
        });
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
    const formData = new FormData(document.getElementById('order-form'));
    
    try {
        const response = await fetch('/includes/process-order.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('Order submitted successfully!', 'success');
            // Reset form or redirect to confirmation page
            window.location.href = '/confirmation.php';
        } else {
            showNotification('Error submitting order. Please try again.', 'error');
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