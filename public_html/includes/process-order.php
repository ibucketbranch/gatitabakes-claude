<?php
header('Content-Type: application/json');

// Include configuration and functions
require_once 'config.php';
require_once 'functions.php';

// Get the raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON data']);
    exit;
}

try {
    // Validate required fields
    $required = ['customer', 'orderType', 'items'];
    foreach ($required as $field) {
        if (!isset($data[$field])) {
            throw new Exception("Missing required field: {$field}");
        }
    }

    // Process the order (you can add your order processing logic here)
    $orderNumber = 'GB-' . date('Ymd') . '-' . substr(uniqid(), -4);
    
    // For now, just return success
    echo json_encode([
        'success' => true,
        'message' => 'Order received successfully',
        'orderNumber' => $orderNumber
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
} 