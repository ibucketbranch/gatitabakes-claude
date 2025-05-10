/**
 * Project: Gatita Bakes Online Order System
 * Title: process-order.php
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-06-09
 */
<?php
// Order processing for Gatita Bakes
header('Content-Type: application/json');

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include email template functions
require_once 'email-template.php';

// Get the raw POST data
$json = file_get_contents('php://input');
$orderData = json_decode($json, true);

// Validate required data
if (!$orderData || !isset($orderData['customer']) || !isset($orderData['orderNumber']) || !isset($orderData['items'])) {
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

// Generate HTML and plain text email content using our template
$htmlContent = generate_order_email_html($orderData);
$textContent = generate_order_email_text($orderData);

// Create a boundary for the multipart email
$boundary = md5(time());

// Set up email headers for multipart message
$to = $orderData['customer']['email'];
$subject = "Gatita Bakes - Order Confirmation #{$orderData['orderNumber']}";

// Headers for multipart HTML/text email
$headers = "From: Gatita Bakes <orders@gatitabakes.com>\r\n";
$headers .= "Reply-To: info@gatitabakes.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Create the multipart message body
$message = "--{$boundary}\r\n";
$message .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= $textContent . "\r\n";

$message .= "--{$boundary}\r\n";
$message .= "Content-Type: text/html; charset=iso-8859-1\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= $htmlContent . "\r\n";

$message .= "--{$boundary}--";

// Send confirmation email to customer
$mailSent = mail($to, $subject, $message, $headers);

// Send notification to admin (Katerina)
$adminEmail = "katvalderrama@bucketbranch.com"; // Change to Katerina's email
$adminSubject = "New Order #{$orderData['orderNumber']} - Gatita Bakes";
$adminMailSent = mail($adminEmail, $adminSubject, $message, $headers);

// Log email attempt for debugging
$logFile = 'order_emails.log';
file_put_contents($logFile, date('Y-m-d H:i:s') . " - Attempted to send email for Order #{$orderData['orderNumber']} to {$to}. Result: " . ($mailSent ? 'Success' : 'Failed') . "\n", FILE_APPEND);

// Response to client
if ($mailSent) {
    echo json_encode([
        'success' => true,
        'message' => 'Order received and confirmation email sent',
        'orderNumber' => $orderData['orderNumber']
    ]);
} else {
    // Order received but email failed
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Order received but confirmation email could not be sent',
        'orderNumber' => $orderData['orderNumber']
    ]);
} 