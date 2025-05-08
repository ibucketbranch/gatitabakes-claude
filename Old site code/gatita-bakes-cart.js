/**
 ** Plugin Name:       Gatita Bakes Ordering       **
 * Filename:          gatita-bakes-cart.js
 * Plugin URI:        https://www.gatitabakes.com/
 * Description:       Cart functionality for Gatita Bakes ordering system
 * Version:           1.9.1
 * Author:            Bucketbranch Inc.
 * Author URI:        https://www.gatitabakes.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gatita-bakes-ordering
 */

jQuery(document).ready(function($) {
    console.log('Gatita Bakes Cart JS executing...');

    // --- Event Listeners ---

    console.log('Setting up Add to Cart listener...');
    // IMPORTANT: Use Event Delegation for Add to Cart buttons
    $('#gatita-order-form').on('click', '.gatita-add-to-cart', function(event) {
        event.preventDefault();
        console.log('Add to Cart button clicked (delegated listener)');
        const $button = $(this);
        const productCard = $button.closest('.gatita-product-card');

        if (productCard.length > 0) {
            const productId = productCard.data('product-id');
            const productName = productCard.find('.product-name').text() || productCard.find('h3').text(); // Adjusted selector
            const productPriceText = productCard.find('.product-price').text() || productCard.find('.price').text(); // Adjusted selector
            const productPrice = parseFloat(productPriceText.replace(/[^0-9.]/g, ''));

            console.log(`Extracted Product Info - ID: ${productId}, Name: ${productName}, Price: ${productPrice}`);

            if (productId && productName && !isNaN(productPrice)) {
                // USE THE COMPLEX CART OBJECT'S addItem METHOD
                cart.addItem(productId, productName, productPrice); // Use the main cart object
            } else {
                console.error('Could not extract valid product info from card:', productCard[0]);
            }
        } else {
             console.error('Could not find parent .gatita-product-card for button:', this);
        }
    });

    // --- Form Submission --- Ensure it uses the correct cart data ---
    console.log('Setting up Form Submit listener...');
    $('#gatita-order-form').on('submit', function(event) {
        event.preventDefault();
        console.log('Form submission intercepted.');

        // USE THE COMPLEX CART OBJECT FOR VALIDATION
        if (Object.keys(cart.items).length === 0) { // Check cart.items
            alert('Your cart is empty. Please add items before placing an order.');
            console.log('Form submission blocked: Cart is empty.');
            return;
        }

        // The complex cart object already updates #gatita-cart-data in its updateUI method
        // So, just serialize the form
        const formData = $(this).serialize();
        console.log('Serialized form data (includes #gatita-cart-data): ', formData);

        // Add AJAX call details
        console.log('AJAX URL:', gatita_bakes_ajax.ajax_url);
        console.log('AJAX Nonce:', gatita_bakes_ajax.nonce);

        // Show loading indicator (optional)
        $('#gatita-submit-order').prop('disabled', true).text('Placing Order...');
        $('.gatita-form-message').removeClass('error success').text('').hide(); // Clear previous messages

        $.ajax({
            url: gatita_bakes_ajax.ajax_url, // Defined via wp_localize_script
            type: 'POST',
            data: formData + '&action=gatita_bakes_submit_order&gatita_order_nonce=' + gatita_bakes_ajax.nonce, // Add action and nonce
            dataType: 'json', // Expect JSON response from server
            success: function(response) {
                console.log('AJAX Success Response:', response);
                if (response.success) {
                    console.log('Order successful, redirecting to:', response.data.redirect_url);
                    // Optional: Display success message briefly before redirect
                     $('.gatita-form-message').addClass('success').text(response.data.message || 'Order placed! Redirecting...').show();
                    // Redirect to confirmation page
                    window.location.href = response.data.redirect_url;
                } else {
                    console.error('AJAX Error (Success=false):', response.data.message);
                     $('#gatita-submit-order').prop('disabled', false).text('Place Order');
                    // Display error message to user
                    $('.gatita-form-message').addClass('error').text(response.data.message || 'An error occurred. Please try again.').show();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Request Failed:');
                console.error('  Status:', textStatus);
                console.error('  Error:', errorThrown);
                console.error('  Response Text:', jqXHR.responseText); // Log the raw response
                $('#gatita-submit-order').prop('disabled', false).text('Place Order');
                 $('.gatita-form-message').addClass('error').text('A network error occurred. Please check your connection and try again.').show();
            }
        });
    });

    // --- Swiper Initialization ---
    function initializeSwiper() {
        console.log('Attempting to initialize Swiper...');
        const swiperContainer = $('.product-swiper');

        if (swiperContainer.length > 0 && typeof Swiper !== 'undefined') {
            console.log('Swiper container found and Swiper library loaded.');

             // Destroy existing instance if it exists
            if (swiperContainer[0].swiper) {
                 console.log('Destroying existing Swiper instance.');
                 swiperContainer[0].swiper.destroy(true, true);
            }

            const productSwiper = new Swiper(swiperContainer[0], {
                // Optional parameters
                slidesPerView: 1,
                spaceBetween: 10,
                 loop: false, // Avoid loop if causing issues with dynamic content/events
                 observer: true, // Detect changes to swiper container
                 observeParents: true, // Detect changes to swiper container's parents
                 resizeObserver: true, // Detect container resize

                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },

                // Pagination
                 pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                 },

                // Responsive breakpoints
                breakpoints: {
                    // when window width is >= 640px
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 15
                    },
                    // when window width is >= 1024px
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    }
                },
                 on: {
                    init: function () {
                      console.log('Swiper initialized!');
                      console.log('Swiper Slides Count:', this.slides.length);
                    },
                    slideChange: function () {
                      console.log('Swiper slide changed to index:', this.activeIndex);
                    },
                    resize: function() {
                        console.log('Swiper resize detected. Current slidesPerView:', this.params.slidesPerView);
                    }
                 }
            });
            console.log('New Swiper instance created:', productSwiper);
            // ADD: Log effective parameters after initialization
            if(productSwiper && productSwiper.params) {
                console.log('Swiper Effective Params (after init):', {
                    slidesPerView: productSwiper.params.slidesPerView,
                    spaceBetween: productSwiper.params.spaceBetween,
                    breakpoints: productSwiper.params.breakpoints
                });
            } else {
                console.warn('Could not log Swiper params.');
            }
        } else {
            if (swiperContainer.length === 0) {
                 console.warn('Swiper container (.product-swiper) not found.');
            }
            if (typeof Swiper === 'undefined') {
                 console.error('Swiper library is not loaded.');
            }
        }
    }

    // REMOVE: setTimeout(initializeSwiper, 500);
    // ADD: Call initializeSwiper directly within document ready
    initializeSwiper();

    // Cart functionality - THIS IS THE OBJECT WE KEEP AND USE
    let cart = {
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
            
            // Show feedback
            $('.gatita-cart-notification').remove();
            const notification = $('<div class="gatita-cart-notification">Item added to cart!</div>');
            $('body').append(notification);
            setTimeout(() => notification.fadeOut(300, function() { $(this).remove(); }), 2000);
        },
        
        removeItem: function(id) {
            console.log('Removing item:', id);
            delete this.items[id];
            this.saveToStorage();
            this.updateUI();
        },
        
        saveToStorage: function() {
            console.log('Saving cart to storage');
            localStorage.setItem('gatitaCart', JSON.stringify(this.items));
        },
        
        loadFromStorage: function() {
            console.log('Loading cart from storage');
            const stored = localStorage.getItem('gatitaCart');
            if (stored) {
                try {
                    this.items = JSON.parse(stored);
                    console.log('Loaded items:', this.items);
                } catch (e) {
                    console.error('Error loading cart:', e);
                    this.items = {};
                }
                this.updateUI();
            }
        },
        
        updateUI: function() {
            console.log('[updateUI] Starting UI update...');
            console.log('[updateUI] Current cart items:', JSON.parse(JSON.stringify(this.items)));
            const itemsContainer = $('#gatita-cart-items');
            const totalContainer = $('#gatita-cart-total');
            let total = 0;
            itemsContainer.empty();

            if (Object.keys(this.items).length === 0) {
                itemsContainer.append('<li class="empty-cart-message">Your cart is empty.</li>');
            } else {
                console.log('[updateUI] Calculating total...');
                for (const id in this.items) {
                    if (this.items.hasOwnProperty(id)) {
                        const item = this.items[id];
                        // Ensure price and quantity are numbers for calculation
                        const itemPrice = parseFloat(item.price) || 0;
                        const itemQuantity = parseInt(item.quantity, 10) || 0;
                        const itemTotal = itemPrice * itemQuantity;
                        
                        console.log(`[updateUI] Item ID: ${id}`);
                        console.log(`  - Name: ${item.name}`);
                        console.log(`  - Price (raw): ${item.price}, Parsed: ${itemPrice}`);
                        console.log(`  - Qty (raw): ${item.quantity}, Parsed: ${itemQuantity}`);
                        console.log(`  - Item Total: ${itemPrice} * ${itemQuantity} = ${itemTotal}`);
                        console.log(`  - Running Total Before: ${total}`);

                        total += itemTotal;
                        console.log(`  - Running Total After: ${total}`);

                        itemsContainer.append(
                            `<li class="cart-item" data-product-id="${id}">` +
                                `<span class="item-name">${item.name} (x${itemQuantity})</span>` +
                                `<span class="item-price">$${itemTotal.toFixed(2)}</span>` +
                                '<button class="remove-item" data-id="${id}">Remove</button>' +
                            '</li>'
                        );
                    }
                }
                 console.log('[updateUI] Final calculated total before rounding:', total);
            }

            totalContainer.text(total.toFixed(2));
            console.log('[updateUI] Displayed total:', total.toFixed(2));
            
            // Update hidden input for form submission
            const cartDataString = JSON.stringify(this.items);
            $('#gatita-cart-data').val(cartDataString);
            console.log('[updateUI] Updated hidden #gatita-cart-data with:', cartDataString);
        },
        
        clear: function() {
            console.log('Clearing cart');
            this.items = {};
            this.saveToStorage();
            this.updateUI();
        }
    };

    console.log('Setting up Cart Remove listener...');
    // Keep the remove-item handler that uses the complex cart object
    $(document).on('click', '.remove-item', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        cart.removeItem(id);
    });

    // Initialize cart from localStorage AFTER the object is defined
    console.log('Loading cart from storage...');
    cart.loadFromStorage(); // Keep this here

    // Initialize order type fields
    $('input[name="order_type"]:checked').trigger('change');

    // Order type toggle
    $('input[name="order_type"]').on('change', function() {
        const isDelivery = $(this).val() === 'delivery';
        $('#gatita-pickup-fields').toggle(!isDelivery);
        $('#gatita-delivery-fields').toggle(isDelivery);
        
        // Toggle required fields
        $('#pickup_location').prop('required', !isDelivery);
        $('#delivery_street, #delivery_city, #delivery_zip').prop('required', isDelivery);
    });

    // Phone number formatting
    $('#customer_phone').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length >= 3) {
            value = '(' + value.substr(0,3) + ')-' + value.substr(3);
        }
        if (value.length >= 9) {
            value = value.substr(0,9) + '-' + value.substr(9);
        }
        if (value.length > 14) {
            value = value.substr(0,14);
        }
        $(this).val(value);
    });

    console.log('Cart JS setup complete.');
    // Make cart object globally accessible
    window.cart = cart; // Keep this
}); 