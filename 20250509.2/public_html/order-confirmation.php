/**
 * Project: Gatita Bakes Online Order System
 * Title: Order Confirmation
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-05-09
 */

<?php
include_once 'nocache.php'; // Prevent caching
$page_title = 'Order Confirmation – Gatita Bakes';
$additional_head = '<link rel="stylesheet" href="css/order-form.css">';
require_once 'includes/config.php';
require_once 'includes/header.php';

// Get order number from URL
$order_number = isset($_GET['order']) ? htmlspecialchars($_GET['order']) : '';

// Check if order data exists in our simple file database
$order_data = null;
$order_file = __DIR__ . '/logs/order_' . $order_number . '.json';

if (file_exists($order_file)) {
    $order_json = file_get_contents($order_file);
    $order_data = json_decode($order_json, true);
}
?>

<main>
  <div class="order-form-main-card">
    <?php if ($order_number && $order_data): ?>
      <!-- Order confirmed -->
      <div class="confirmation-container">
        <div class="confirmation-header">
          <div class="confirmation-icon">
            <div class="check-icon">✓</div>
          </div>
          <h1>Thank You for Your Order!</h1>
          <p>Order #<?php echo $order_number; ?> has been received</p>
        </div>
        
        <div class="confirmation-section">
          <h2>Order Summary</h2>
          
          <div class="order-details">
            <div class="detail-item">
              <span class="detail-label">Order Date:</span>
              <span class="detail-value"><?php echo date('F j, Y', strtotime($order_data['orderDate'])); ?></span>
            </div>
            
            <div class="detail-item">
              <span class="detail-label">Order Type:</span>
              <span class="detail-value capitalize"><?php echo $order_data['orderType']; ?></span>
            </div>
            
            <?php if ($order_data['orderType'] === 'pickup'): ?>
              <div class="detail-item">
                <span class="detail-label">Pickup Location:</span>
                <span class="detail-value">
                  <?php 
                    $location = $order_data['pickupLocation'];
                    $location_name = $location;
                    if ($location === 'westsac') {
                      $location_name = 'West Sacramento (Near I St. Bridge)';
                    } else if ($location === 'farmersmarket') {
                      $location_name = 'Sacramento Farmers Market';
                    }
                    echo $location_name;
                  ?>
                </span>
              </div>
            <?php else: ?>
              <div class="detail-delivery">
                <span class="detail-label">Delivery Address:</span>
                <span class="detail-value">
                  <?php 
                    $address = $order_data['deliveryAddress'];
                    echo $address['street'] . '<br>';
                    if (!empty($address['unit'])) echo $address['unit'] . '<br>';
                    echo $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
                  ?>
                </span>
              </div>
            <?php endif; ?>
            
            <div class="detail-item">
              <span class="detail-label">Customer:</span>
              <span class="detail-value">
                <?php echo $order_data['customer']['firstName'] . ' ' . $order_data['customer']['lastName']; ?><br>
                <?php echo $order_data['customer']['email']; ?><br>
                <?php echo $order_data['customer']['phone']; ?>
              </span>
            </div>
          </div>
          
          <h3>Items Ordered</h3>
          <table class="order-items-table">
            <thead>
              <tr>
                <th>Item</th>
                <th class="qty">Qty</th>
                <th class="price">Price</th>
                <th class="total">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($order_data['items'] as $item): 
                $itemTotal = $item['price'] * $item['quantity'];
              ?>
                <tr>
                  <td><?php echo $item['name']; ?></td>
                  <td class="qty"><?php echo $item['quantity']; ?></td>
                  <td class="price">$<?php echo number_format($item['price'], 2); ?></td>
                  <td class="total">$<?php echo number_format($itemTotal, 2); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" class="order-total-label">Order Total:</td>
                <td class="order-total-value">$<?php echo number_format($order_data['orderTotal'], 2); ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
        
        <div class="confirmation-section">
          <h2>Payment Information</h2>
          <p>Please complete your payment using one of these methods:</p>
          <ul class="payment-methods">
            <li><strong>Venmo:</strong> @katvalderrama</li>
            <li><strong>Cash:</strong> Available for in-person pickup only</li>
          </ul>
          
          <p class="payment-reference">
            <strong>Payment Reference:</strong> Please include your order number (#<?php echo $order_number; ?>) in your payment note.
          </p>
          
          <div class="venmo-button-container">
            <?php 
              $venmo_url = sprintf(
                'https://venmo.com/%s?txn=pay&amount=%s&note=%s',
                'katvalderrama',
                number_format($order_data['orderTotal'], 2),
                urlencode("GatitaBakes Order #{$order_number}")
              );
            ?>
            <a href="<?php echo $venmo_url; ?>" class="venmo-button" target="_blank">Pay with Venmo</a>
          </div>
        </div>
        
        <div class="confirmation-section">
          <h2>What's Next?</h2>
          <p>Your order will be confirmed once payment is received. You will receive a confirmation email with pickup/delivery details.</p>
          <p>A confirmation email has been sent to <strong><?php echo $order_data['customer']['email']; ?></strong>. If you don't see it, please check your spam folder.</p>
          
          <div class="next-actions">
            <a href="index.php" class="secondary-button">Return to Home</a>
          </div>
        </div>
      </div>
    <?php else: ?>
      <!-- Order not found -->
      <div class="confirmation-container error">
        <h1>Order Not Found</h1>
        <p>Sorry, we couldn't find an order with reference number: <?php echo $order_number ? $order_number : 'No order number provided'; ?></p>
        
        <div class="next-actions">
          <a href="order-form.php" class="primary-button">Place an Order</a>
          <a href="index.php" class="secondary-button">Return to Home</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</main>

<style>
.confirmation-container {
  max-width: 800px;
  margin: 2rem auto;
  padding: 2rem;
  background-color: white;
  border-radius: 14px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.confirmation-header {
  text-align: center;
  margin-bottom: 3rem;
}

.confirmation-icon {
  display: flex;
  justify-content: center;
  margin-bottom: 1.5rem;
}

.check-icon {
  background-color: #8B5E3C;
  color: white;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 40px;
  font-weight: bold;
}

.confirmation-header h1 {
  font-size: 2.2rem;
  color: #4A3728;
  margin-bottom: 0.5rem;
}

.confirmation-header p {
  font-size: 1.2rem;
  color: #7D6E63;
}

.confirmation-section {
  margin-bottom: 3rem;
  padding-bottom: 2rem;
  border-bottom: 1px solid #f0e6d9;
}

.confirmation-section:last-child {
  border-bottom: none;
  padding-bottom: 0;
}

.confirmation-section h2 {
  font-size: 1.8rem;
  color: #8B5E3C;
  margin-bottom: 1.5rem;
}

.confirmation-section h3 {
  font-size: 1.4rem;
  color: #4A3728;
  margin: 2rem 0 1rem;
}

.order-details {
  background-color: #FFF8F0;
  padding: 1.5rem;
  border-radius: 10px;
  margin-bottom: 2rem;
}

.detail-item {
  display: flex;
  margin-bottom: 1rem;
}

.detail-label {
  flex: 0 0 200px;
  font-weight: 600;
  color: #4A3728;
}

.detail-value {
  flex: 1;
  color: #7D6E63;
}

.detail-delivery {
  display: flex;
  margin-bottom: 1rem;
}

.capitalize {
  text-transform: capitalize;
}

.order-items-table {
  width: 100%;
  border-collapse: collapse;
  margin: 1rem 0 2rem;
}

.order-items-table th,
.order-items-table td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid #f0e6d9;
}

.order-items-table th {
  font-weight: 600;
  color: #8B5E3C;
  background-color: #FFF8F0;
}

.order-items-table .qty,
.order-items-table .price,
.order-items-table .total {
  text-align: right;
}

.order-items-table tfoot td {
  border-bottom: none;
  border-top: 2px solid #D2B48C;
  padding-top: 1.5rem;
}

.order-total-label {
  text-align: right;
  font-weight: 600;
  color: #4A3728;
}

.order-total-value {
  font-weight: 700;
  font-size: 1.2rem;
  color: #8B5E3C;
}

.payment-methods {
  list-style-type: none;
  padding-left: 0;
  margin-bottom: 1.5rem;
}

.payment-methods li {
  margin-bottom: 0.5rem;
  color: #7D6E63;
}

.payment-reference {
  background-color: #FFF8F0;
  padding: 1rem;
  border-radius: 8px;
  margin: 1.5rem 0;
}

.venmo-button-container {
  text-align: center;
  margin: 2rem 0;
}

.venmo-button {
  display: inline-block;
  background-color: #008CFF;
  color: white;
  padding: 1rem 2.5rem;
  border-radius: 30px;
  text-decoration: none;
  font-weight: 600;
  font-size: 1.1rem;
  transition: background-color 0.3s ease;
}

.venmo-button:hover {
  background-color: #0070CC;
}

.next-actions {
  display: flex;
  justify-content: center;
  gap: 1.5rem;
  margin-top: 2rem;
}

.primary-button, .secondary-button {
  display: inline-block;
  padding: 1rem 2rem;
  border-radius: 30px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
}

.primary-button {
  background-color: #8B5E3C;
  color: white;
}

.primary-button:hover {
  background-color: #4A3728;
}

.secondary-button {
  background-color: #FFF8F0;
  color: #8B5E3C;
  border: 1px solid #D2B48C;
}

.secondary-button:hover {
  background-color: #D2B48C;
  color: white;
}

.error {
  text-align: center;
}

.error h1 {
  color: #8B5E3C;
  margin-bottom: 1rem;
}

.error p {
  color: #7D6E63;
  margin-bottom: 2rem;
}

@media (max-width: 768px) {
  .confirmation-container {
    padding: 1.5rem;
  }
  
  .detail-item, .detail-delivery {
    flex-direction: column;
  }
  
  .detail-label {
    margin-bottom: 0.5rem;
  }
  
  .order-items-table th,
  .order-items-table td {
    padding: 0.75rem;
  }
  
  .next-actions {
    flex-direction: column;
    gap: 1rem;
  }
  
  .primary-button, .secondary-button {
    width: 100%;
    text-align: center;
  }
}
</style>

<?php require_once 'includes/footer.php'; ?> 