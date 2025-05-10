/**
 * Project: Gatita Bakes Online Order System
 * Title: process-order.php
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-05-09
 */
<?php
// Order processing for Gatita Bakes
header('Content-Type: application/json');

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include email template functions
require_once 'email-template.php';
require_once 'config.php';

// Get the raw POST data
$json = file_get_contents('php://input');
$orderData = json_decode($json, true);

// Create a log directory if it doesn't exist
$logDir = __DIR__ . '/../logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0755, true);
}

// Log the raw order data for debugging
file_put_contents($logDir . '/order_data.log', date('Y-m-d H:i:s') . " - Order Data: " . $json . "\n", FILE_APPEND);

// Validate required data
if (!$orderData || !isset($orderData['customer']) || !isset($orderData['items']) || empty($orderData['items'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required order data']);
    exit;
}

// Verify we have an email to send to
if (!isset($orderData['customer']['email']) || empty($orderData['customer']['email'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Customer email is required']);
    exit;
}

// Use provided order number or generate a new one
$orderNumber = isset($orderData['orderNumber']) ? $orderData['orderNumber'] : 'GB' . date('YmdHis');

// Calculate order total
$orderTotal = 0;
foreach ($orderData['items'] as $item) {
    $orderTotal += $item['price'] * $item['quantity'];
}

// Add order total to the data
$orderData['orderTotal'] = $orderTotal;
$orderData['orderNumber'] = $orderNumber;
$orderData['orderDate'] = isset($orderData['orderDate']) ? $orderData['orderDate'] : date('Y-m-d H:i:s');

// Generate HTML and plain text email content using our template
$htmlContent = generate_order_email_html($orderData);
$textContent = generate_order_email_text($orderData);

// Create a boundary for the multipart email
$boundary = md5(time());

// Set up email headers for multipart message
$to = $orderData['customer']['email'];
$subject = "Gatita Bakes - Order Confirmation #{$orderNumber}";

// Headers for multipart HTML/text email
$headers = "From: Gatita Bakes <" . SITE_EMAIL . ">\r\n";
$headers .= "Reply-To: " . SITE_EMAIL . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Create the multipart message body
$message = "--{$boundary}\r\n";
$message .= "Content-Type: text/plain; charset=utf-8\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= $textContent . "\r\n";

$message .= "--{$boundary}\r\n";
$message .= "Content-Type: text/html; charset=utf-8\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= $htmlContent . "\r\n";

$message .= "--{$boundary}--";

// Send confirmation email to customer
$mailSent = mail($to, $subject, $message, $headers);

// Send notification to admin
$adminEmail = ADMIN_EMAIL;
$adminSubject = "New Order #{$orderNumber} - Gatita Bakes";
$adminMailSent = mail($adminEmail, $adminSubject, $message, $headers);

// Store order data in a file (simple order database)
$orderDataJson = json_encode($orderData, JSON_PRETTY_PRINT);
$orderFile = $logDir . '/order_' . $orderNumber . '.json';
$orderSaved = file_put_contents($orderFile, $orderDataJson);

// Log email attempt for debugging
$logFile = $logDir . '/order_emails.log';
file_put_contents($logFile, date('Y-m-d H:i:s') . " - Order #{$orderNumber} - Email to {$to}: " . ($mailSent ? 'Success' : 'Failed') . " | Admin email: " . ($adminMailSent ? 'Success' : 'Failed') . " | Order saved: " . ($orderSaved ? 'Success' : 'Failed') . "\n", FILE_APPEND);

// Response to client
if ($mailSent || $orderSaved) {
    echo json_encode([
        'success' => true,
        'message' => $mailSent ? 'Order received and confirmation email sent' : 'Order received but email could not be sent',
        'orderNumber' => $orderNumber
    ]);
} else {
    // Order processing failed
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to process order',
        'orderNumber' => $orderNumber
    ]);
} 