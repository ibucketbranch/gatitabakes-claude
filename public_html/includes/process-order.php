<?php
header('Content-Type: application/json');

// Prevent direct access
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get and validate form data
$formData = $_POST;
$cart = json_decode($formData['cart'] ?? '[]', true);

// Basic validation
if (empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Cart is empty']);
    exit;
}

if (empty($formData['name']) || empty($formData['email']) || empty($formData['phone'])) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
    exit;
}

if (empty($formData['pickup-date']) || empty($formData['pickup-time'])) {
    echo json_encode(['success' => false, 'message' => 'Please select pickup date and time']);
    exit;
}

// Validate email
if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
    exit;
}

// Process the order (in a real application, you would save to database here)
// For now, we'll just send a success response
$response = [
    'success' => true,
    'message' => 'Order received successfully! We will contact you to confirm your order.',
    'order' => [
        'name' => $formData['name'],
        'email' => $formData['email'],
        'phone' => $formData['phone'],
        'pickup_date' => $formData['pickup-date'],
        'pickup_time' => $formData['pickup-time'],
        'special_instructions' => $formData['special-instructions'] ?? '',
        'cart' => $cart
    ]
];

echo json_encode($response); 