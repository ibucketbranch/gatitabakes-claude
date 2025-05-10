/**
 * Project: Gatita Bakes Online Order System
 * Title: functions.php
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-06-09
 */
<?php
require_once 'config.php';

/**
 * Sanitize user input
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Format price with currency symbol
 */
function format_price($price) {
    return '$' . number_format($price, 2);
}

/**
 * Calculate tax amount
 */
function calculate_tax($amount, $rate = 0.085) {
    return $amount * $rate;
}

/**
 * Validate date is in the future
 */
function is_valid_future_date($date) {
    $date_obj = new DateTime($date);
    $today = new DateTime();
    return $date_obj > $today;
}

/**
 * Get available pickup times
 */
function get_pickup_times() {
    return [
        '7am-9am' => '7:00 AM - 9:00 AM',
        '9am-11am' => '9:00 AM - 11:00 AM',
        '11am-1pm' => '11:00 AM - 1:00 PM',
        '1pm-3pm' => '1:00 PM - 3:00 PM'
    ];
}

/**
 * Format phone number
 */
function format_phone($phone) {
    $cleaned = preg_replace('/[^0-9]/', '', $phone);
    if(strlen($cleaned) === 10) {
        return preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '($1) $2-$3', $cleaned);
    }
    return $phone;
} 