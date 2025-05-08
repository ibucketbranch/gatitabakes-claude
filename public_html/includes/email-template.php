<?php
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
    $total = $orderData['total'];
    $notes = $orderData['notes'] ?? '';
    
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
        $locationDetails = "<p><strong>Pickup Location:</strong> {$orderData['pickupLocation']}</p>";
    }
    
    // Create items HTML
    $itemsHtml = '';
    foreach ($items as $item) {
        $price = $item['price'] * $item['quantity'];
        $itemsHtml .= "
            <tr>
                <td>{$item['name']}</td>
                <td class=\"qty\">{$item['quantity']}</td>
                <td class=\"price\">\${$price}</td>
            </tr>";
    }
    
    // Generate Venmo payment URL
    $venmoUrl = sprintf(
        'https://venmo.com/%s?txn=pay&amount=%s&note=%s',
        'katvalderrama',
        urlencode($total),
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
                color: #333;
                margin: 0;
                padding: 0;
                background-color: #f9f9f9;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #ffffff;
            }
            .header {
                text-align: center;
                padding: 20px 0;
                border-bottom: 2px solid #e5a98c;
            }
            .header h1 {
                color: #8b4513;
                margin: 0;
                font-size: 24px;
            }
            .greeting {
                margin-top: 20px;
            }
            .order-details {
                margin: 30px 0;
            }
            .order-details h2 {
                color: #5a4e46;
                font-size: 18px;
                border-bottom: 1px solid #e5a98c;
                padding-bottom: 5px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 15px 0;
            }
            table th {
                text-align: left;
                padding: 10px;
                background: #fdfaf7;
                border-bottom: 2px solid #e5a98c;
            }
            table td {
                padding: 10px;
                border-bottom: 1px solid #eee;
            }
            table .qty {
                text-align: center;
                width: 60px;
            }
            table .price {
                text-align: right;
                width: 100px;
            }
            .total {
                text-align: right;
                font-weight: bold;
                margin-top: 15px;
                padding-top: 15px;
                border-top: 2px solid #e5a98c;
                font-size: 16px;
            }
            .info-box {
                background: #fdfaf7;
                padding: 15px;
                border-radius: 5px;
                margin: 20px 0;
                border: 1px solid #e5a98c;
            }
            .info-box h3 {
                color: #8b4513;
                margin-top: 0;
                font-size: 16px;
            }
            .button {
                display: inline-block;
                background-color: #008CFF;
                color: white;
                text-decoration: none;
                padding: 12px 25px;
                border-radius: 5px;
                margin: 15px 0;
                font-weight: bold;
            }
            .important {
                color: #721c24;
                background: #f8d7da;
                padding: 15px;
                border-radius: 5px;
                margin: 20px 0;
                border: 1px solid #f5c6cb;
            }
            .footer {
                margin-top: 30px;
                text-align: center;
                color: #666;
                font-size: 12px;
                padding-top: 20px;
                border-top: 1px solid #eee;
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
                <p>Thank you for choosing Gatita Bakes! Your order has been received and is pending payment.</p>
            </div>
            
            <div class="order-details">
                <h2>Order Summary</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="qty">Qty</th>
                            <th class="price">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        $itemsHtml
                    </tbody>
                </table>
                <div class="total">
                    Total: \${$total}
                </div>
            </div>
            
            <div class="info-box">
                <h3>Your Information</h3>
                <p><strong>Name:</strong> {$customer['firstName']} {$customer['lastName']}</p>
                <p><strong>Email:</strong> {$customer['email']}</p>
                <p><strong>Phone:</strong> {$customer['phone']}</p>
                
                <h3>" . ucfirst($orderType) . " Details</h3>
                $locationDetails
                
                " . (!empty($notes) ? "<p><strong>Notes:</strong> {$notes}</p>" : "") . "
            </div>
            
            <div class="info-box">
                <h3>Payment Instructions</h3>
                <p>Please send payment via Venmo to: <strong>@katvalderrama</strong></p>
                <p>Include your order number (#$orderNumber) in the payment note.</p>
                <div style="text-align: center;">
                    <a href="$venmoUrl" class="button" style="color: white;">
                        Pay \${$total} on Venmo
                    </a>
                </div>
            </div>
            
            <div class="important">
                <strong>Important:</strong> Your order is not confirmed until payment is received and verified. Katerina will contact you to confirm payment and arrange pickup/delivery.
            </div>
            
            <p>If you have any questions, please don't hesitate to contact us at info@gatitabakes.com</p>
            <p>Thank you for supporting Gatita Bakes!</p>
            
            <div class="footer">
                <p>&copy; " . date('Y') . " Gatita Bakes. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    HTML;
    
    return $html;
}

/**
 * Generate plain-text version of email for clients that don't support HTML
 */
function generate_order_email_text($orderData) {
    $customer = $orderData['customer'];
    $orderNumber = $orderData['orderNumber'];
    $orderType = $orderData['orderType'];
    $items = $orderData['items'];
    $total = $orderData['total'];
    $notes = $orderData['notes'] ?? '';
    
    // Format address or pickup location
    $locationDetails = '';
    if ($orderType === 'delivery' && isset($orderData['deliveryAddress'])) {
        $address = $orderData['deliveryAddress'];
        $locationDetails = "Delivery Address: {$address['street']}";
        if (!empty($address['unit'])) {
            $locationDetails .= ", {$address['unit']}";
        }
        $locationDetails .= "\n{$address['city']}, {$address['state']} {$address['zip']}";
    } elseif ($orderType === 'pickup' && isset($orderData['pickupLocation'])) {
        $locationDetails = "Pickup Location: {$orderData['pickupLocation']}";
    }
    
    // Create items text
    $itemsText = '';
    foreach ($items as $item) {
        $price = $item['price'] * $item['quantity'];
        $itemsText .= "{$item['quantity']} x {$item['name']} - \${$price}\n";
    }
    
    // Plain text email
    $text = <<<TEXT
THANK YOU FOR YOUR ORDER!
Order #{$orderNumber}

Hi {$customer['firstName']},

Thank you for choosing Gatita Bakes! Your order has been received and is pending payment.

ORDER SUMMARY:
--------------
{$itemsText}
Total: \${$total}

YOUR INFORMATION:
----------------
Name: {$customer['firstName']} {$customer['lastName']}
Email: {$customer['email']}
Phone: {$customer['phone']}

" . strtoupper($orderType) . " DETAILS:
----------------
{$locationDetails}
TEXT;

    if (!empty($notes)) {
        $text .= "\nNotes: {$notes}";
    }

    $text .= <<<TEXT


PAYMENT INSTRUCTIONS:
-------------------
Please send payment via Venmo to: @katvalderrama
Include your order number (#{$orderNumber}) in the payment note.

IMPORTANT: Your order is not confirmed until payment is received and verified.
Katerina will contact you to confirm payment and arrange pickup/delivery.

If you have any questions, please contact info@gatitabakes.com

Thank you for supporting Gatita Bakes!
TEXT;

    return $text;
} 