/**
 * Project: Gatita Bakes Online Order System
 * Title: email-template.php
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-05-09
 */
/**
 * Email Template for Gatita Bakes Order Confirmation
 *
 * This template generates HTML content for order confirmation emails
 */
function generate_order_email_html($orderData) {
    $customer = $orderData['customer'];
    $orderNumber = $orderData['orderNumber'];
    $orderType = $orderData['orderType'];
    $items = $orderData['items'];
    
    // Use orderTotal from the data if available, otherwise calculate it
    $total = isset($orderData['orderTotal']) ? $orderData['orderTotal'] : 0;
    if ($total == 0) {
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    
    $notes = isset($orderData['notes']) ? $orderData['notes'] : '';
    $orderDate = isset($orderData['orderDate']) ? date('F j, Y', strtotime($orderData['orderDate'])) : date('F j, Y');
    
    // Format address or pickup location
    $locationDetails = '';
    if ($orderType === 'delivery' && isset($orderData['deliveryAddress'])) {
        $address = $orderData['deliveryAddress'];
        $locationDetails = "
            <p><strong>Delivery Address:</strong><br>
            {$address['street']}";
        
        if (!empty($address['unit'])) {
            $locationDetails .= "<br>{$address['unit']}";
        }
        
        $locationDetails .= "<br>{$address['city']}, {$address['state']} {$address['zip']}</p>";
    } elseif ($orderType === 'pickup' && isset($orderData['pickupLocation'])) {
        $pickupLocationName = '';
        
        switch ($orderData['pickupLocation']) {
            case 'westsac':
                $pickupLocationName = 'West Sacramento (Near I St. Bridge)';
                break;
            case 'farmersmarket':
                $pickupLocationName = 'Sacramento Farmers Market';
                break;
            default:
                $pickupLocationName = $orderData['pickupLocation'];
        }
        
        $locationDetails = "<p><strong>Pickup Location:</strong> {$pickupLocationName}</p>";
        
        // Add detailed address for West Sacramento location
        if ($orderData['pickupLocation'] === 'westsac') {
            $locationDetails .= "
                <div class='pickup-details'>
                    <p><strong>Full Address:</strong><br>
                    291 McDowell Lane<br>
                    West Sacramento, CA 95605</p>
                    
                    <p class='location-note'><em>Note: Across the street from Burgers & Brew</em></p>
                    
                    <div class='map-container'>
                        <a href='https://maps.google.com/?q=291+McDowell+Ln,+West+Sacramento,+CA+95605' target='_blank'>
                            View on Google Maps
                        </a>
                    </div>
                </div>";
        } elseif ($orderData['pickupLocation'] === 'farmersmarket') {
            $locationDetails .= "
                <div class='pickup-details'>
                    <p class='location-note'><em>Katerina will provide specific market location and time details when confirming your order.</em></p>
                </div>";
        }
    }
    
    // Create items HTML
    $itemsHtml = '';
    foreach ($items as $item) {
        $itemTotal = number_format($item['price'] * $item['quantity'], 2);
        $itemPrice = number_format($item['price'], 2);
        
        $itemsHtml .= "
            <tr>
                <td>{$item['name']}</td>
                <td class=\"qty\">{$item['quantity']}</td>
                <td class=\"unit-price\">\${$itemPrice}</td>
                <td class=\"price\">\${$itemTotal}</td>
            </tr>";
    }
    
    // Generate Venmo payment URL
    $venmoUrl = sprintf(
        'https://venmo.com/%s?txn=pay&amount=%s&note=%s',
        'katvalderrama',
        number_format($total, 2),
        urlencode("GatitaBakes Order #{$orderNumber}")
    );

    // Full HTML email template
    $html = <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Gatita Bakes Order Confirmation</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #4A3728;
                margin: 0;
                padding: 0;
                background-color: #FFF8F0;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 12px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            }
            .header {
                text-align: center;
                padding: 25px 0;
                border-bottom: 2px solid #D2B48C;
            }
            .header h1 {
                color: #8B5E3C;
                margin: 0;
                font-size: 28px;
                font-weight: 700;
            }
            .greeting {
                margin-top: 25px;
            }
            .order-details {
                margin: 30px 0;
            }
            .order-details h2 {
                color: #8B5E3C;
                font-size: 20px;
                border-bottom: 1px solid #D2B48C;
                padding-bottom: 8px;
            }
            .order-meta {
                background: #FFF8F0;
                padding: 12px;
                border-radius: 8px;
                margin-bottom: 20px;
            }
            .order-meta p {
                margin: 5px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 15px 0;
            }
            table th {
                text-align: left;
                padding: 12px;
                background: #FFF8F0;
                border-bottom: 2px solid #D2B48C;
                color: #8B5E3C;
            }
            table td {
                padding: 12px;
                border-bottom: 1px solid #f0e6d9;
            }
            table .qty {
                text-align: center;
                width: 60px;
            }
            table .unit-price {
                text-align: right;
                width: 80px;
            }
            table .price {
                text-align: right;
                width: 100px;
                font-weight: 600;
            }
            .total {
                text-align: right;
                font-weight: bold;
                margin-top: 15px;
                padding: 15px;
                border-top: 2px solid #D2B48C;
                font-size: 18px;
                background: #FFF8F0;
                border-radius: 8px;
            }
            .info-box {
                background: #FFF8F0;
                padding: 20px;
                border-radius: 8px;
                margin: 25px 0;
                border: 1px solid #D2B48C;
            }
            .info-box h3 {
                color: #8B5E3C;
                margin-top: 0;
                font-size: 18px;
            }
            .button {
                display: inline-block;
                background-color: #8B5E3C;
                color: white;
                text-decoration: none;
                padding: 14px 30px;
                border-radius: 40px;
                margin: 15px 0;
                font-weight: bold;
                text-align: center;
            }
            .button:hover {
                background-color: #4A3728;
            }
            .important {
                color: #8B5E3C;
                background: #FFF8F0;
                padding: 15px;
                border-radius: 8px;
                margin: 20px 0;
                border: 1px solid #D2B48C;
            }
            .footer {
                margin-top: 30px;
                text-align: center;
                color: #7D6E63;
                font-size: 14px;
                padding: 20px;
                border-top: 1px solid #f0e6d9;
            }
            .pickup-details {
                background: #FFF8F0;
                padding: 15px;
                border-radius: 8px;
                margin: 15px 0;
                border: 1px solid #D2B48C;
            }
            
            .location-note {
                color: #7D6E63;
                font-style: italic;
                margin: 10px 0;
            }
            
            .map-container {
                margin: 15px 0;
            }
            
            .map-container a {
                display: inline-block;
                background-color: #8B5E3C;
                color: white;
                text-decoration: none;
                padding: 10px 20px;
                border-radius: 30px;
                font-weight: 600;
                text-align: center;
            }
            
            .map-container a:hover {
                background-color: #4A3728;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Thank You for Your Order!</h1>
                <p>Order #$orderNumber</p>
            </div>
            
            <div class="greeting">
                <p>Hi {$customer['firstName']},</p>
                <p>Thank you for choosing Gatita Bakes! Your order has been received and is being processed.</p>
            </div>
            
            <div class="order-details">
                <h2>Order Information</h2>
                <div class="order-meta">
                    <p><strong>Order Date:</strong> {$orderDate}</p>
                    <p><strong>Order Type:</strong> {$orderType}</p>
                    $locationDetails
                </div>
                
                <h2>Order Summary</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="qty">Qty</th>
                            <th class="unit-price">Price</th>
                            <th class="price">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        $itemsHtml
                    </tbody>
                </table>
                <div class="total">
                    Total: \$" . number_format($total, 2) . "
                </div>
            </div>
            
            <div class="info-box">
                <h3>Payment Information</h3>
                <p>Please complete your payment using one of the following methods:</p>
                <ol>
                    <li>Venmo: @katvalderrama</li>
                    <li>Cash: Available for in-person pickup only</li>
                </ol>
                <p><strong>Payment Reference:</strong> Please include your order number (#$orderNumber) in your payment note.</p>
                <div style="text-align: center;">
                    <a href=\"$venmoUrl\" class="button">Pay with Venmo</a>
                </div>
            </div>
            
            <div class="important">
                <h3>Important Notes</h3>
                <p>Your order will be confirmed once payment is received. You will receive a confirmation email with pickup/delivery details.</p>
                <p>If you have any questions or need to make changes to your order, please contact us at info@gatitabakes.com or (555) 123-4567.</p>
            </div>
            
            <div class="footer">
                <p>Gatita Bakes - Artisan Sourdough Bread</p>
                <p>Sacramento, California</p>
                <p>© " . date('Y') . " Gatita Bakes. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    HTML;
    
    return $html;
}

/**
 * Plain text email version for non-HTML email clients
 */
function generate_order_email_text($orderData) {
    $customer = $orderData['customer'];
    $orderNumber = $orderData['orderNumber'];
    $orderType = $orderData['orderType'];
    $items = $orderData['items'];
    
    // Use orderTotal if available, otherwise calculate
    $total = isset($orderData['orderTotal']) ? $orderData['orderTotal'] : 0;
    if ($total == 0) {
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    
    $orderDate = isset($orderData['orderDate']) ? date('F j, Y', strtotime($orderData['orderDate'])) : date('F j, Y');
    
    // Build plain text email
    $text = "GATITA BAKES - ORDER CONFIRMATION\n";
    $text .= "============================\n\n";
    $text .= "Order #$orderNumber\n";
    $text .= "Date: $orderDate\n\n";
    
    $text .= "Hi {$customer['firstName']},\n\n";
    $text .= "Thank you for choosing Gatita Bakes! Your order has been received and is being processed.\n\n";
    
    $text .= "ORDER INFORMATION\n";
    $text .= "------------------\n";
    $text .= "Order Type: " . ucfirst($orderType) . "\n";
    
    if ($orderType === 'delivery' && isset($orderData['deliveryAddress'])) {
        $address = $orderData['deliveryAddress'];
        $text .= "Delivery Address:\n";
        $text .= "{$address['street']}\n";
        
        if (!empty($address['unit'])) {
            $text .= "{$address['unit']}\n";
        }
        
        $text .= "{$address['city']}, {$address['state']} {$address['zip']}\n\n";
    } elseif ($orderType === 'pickup' && isset($orderData['pickupLocation'])) {
        $pickupLocationName = '';
        
        switch ($orderData['pickupLocation']) {
            case 'westsac':
                $pickupLocationName = 'West Sacramento (Near I St. Bridge)';
                break;
            case 'farmersmarket':
                $pickupLocationName = 'Sacramento Farmers Market';
                break;
            default:
                $pickupLocationName = $orderData['pickupLocation'];
        }
        
        $text .= "Pickup Location: {$pickupLocationName}\n\n";
        
        if ($orderData['pickupLocation'] === 'westsac') {
            $text .= "Full Address:\n";
            $text .= "291 McDowell Lane\n";
            $text .= "West Sacramento, CA 95605\n";
            $text .= "(Across the street from Burgers & Brew)\n\n";
        } elseif ($orderData['pickupLocation'] === 'farmersmarket') {
            $text .= "Katerina will provide specific market location and time details when confirming your order.\n\n";
        }
    }
    
    $text .= "ORDER SUMMARY\n";
    $text .= "-------------\n";
    
    foreach ($items as $item) {
        $itemTotal = number_format($item['price'] * $item['quantity'], 2);
        $text .= "{$item['name']} x {$item['quantity']} - \${$itemTotal}\n";
    }
    
    $text .= "\nTOTAL: \$" . number_format($total, 2) . "\n\n";
    
    $text .= "PAYMENT INFORMATION\n";
    $text .= "-------------------\n";
    $text .= "Please complete your payment using one of the following methods:\n\n";
    $text .= "1. Venmo: @katvalderrama\n";
    $text .= "2. Cash: Available for in-person pickup only\n\n";
    $text .= "Payment Reference: Please include your order number (#$orderNumber) in your payment note.\n\n";
    
    $text .= "IMPORTANT NOTES\n";
    $text .= "--------------\n";
    $text .= "Your order will be confirmed once payment is received. You will receive a confirmation email with pickup/delivery details.\n\n";
    $text .= "If you have any questions or need to make changes to your order, please contact us at info@gatitabakes.com or (555) 123-4567.\n\n";
    
    $text .= "Gatita Bakes - Artisan Sourdough Bread\n";
    $text .= "Sacramento, California\n";
    $text .= "© " . date('Y') . " Gatita Bakes. All rights reserved.\n";
    
    return $text;
} 