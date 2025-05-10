/**
 * Project: Gatita Bakes Online Order System
 * Title: email-config.php
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-06-09
 * 
 * Email Integration with EmailJS Setup Guide
 */

/*
This guide will help you set up EmailJS for sending confirmation emails from your
bread ordering application. EmailJS allows you to send emails directly from 
JavaScript code without needing a backend server.

STEP 1: Create an EmailJS account
-------------------------------
1. Go to https://www.emailjs.com/ and sign up for a free account
2. The free plan includes 200 emails per month

STEP 2: Set up an Email Service
------------------------------
1. In the EmailJS dashboard, go to "Email Services"
2. Click "Add New Service"
3. Choose your email provider (Gmail, Outlook, etc.)
4. Follow the instructions to connect your email account

STEP 3: Create Email Templates
----------------------------
You'll need to create two templates:
1. Customer Order Confirmation
2. Admin Order Notification

For the Customer Order Confirmation template:
1. Go to "Email Templates" in the dashboard
2. Click "Create New Template"
3. Set up a template with the following parameters:

Template Name: customer_order_confirmation
Subject: Your Artisan Bread Co. Order #{{order_number}}

Body:
```
Hello {{to_name}},

Thank you for your order with Artisan Bread Co.!

Order Number: {{order_number}}

Order Details:
{{order_details}}

Total Amount: ${{total_amount}}

{{delivery_info}}

Payment Instructions:
Please send payment via Venmo to {{venmo_username}} and include your order number in the payment notes.

If you have any questions or need assistance, please reply to this email.

Thank you,
Artisan Bread Co. Team
```

For the Admin Order Notification template:
1. Create another new template
2. Set up with these parameters:

Template Name: admin_order_notification
Subject: New Order #{{order_number}} Received

Body:
```
A new order has been received!

Order Number: {{order_number}}

Customer Information:
Name: {{to_name}}
Email: {{customer_email}}
Phone: {{customer_phone}}

Order Details:
{{order_details}}

Total Amount: ${{total_amount}}

{{delivery_info}}

Payment Status: Pending Venmo payment

Please check your Venmo account for payment from the customer.
```

STEP 4: Get your EmailJS User ID and Template IDs
-----------------------------------------------
1. In the EmailJS dashboard, go to "Integration"
2. Copy your User ID (will be used in your code)
3. Note down the Template IDs for both templates you created

STEP 5: Update the BreadOrderForm Component
-----------------------------------------
1. Replace the placeholder IDs in the component with your actual IDs:

```javascript
// Replace these with your actual EmailJS service ID, template ID, and user ID
const serviceId = 'YOUR_EMAILJS_SERVICE_ID';
const customerTemplateId = 'YOUR_CUSTOMER_TEMPLATE_ID';
const adminTemplateId = 'YOUR_ADMIN_TEMPLATE_ID';
const userId = 'YOUR_EMAILJS_USER_ID';
```

2. Make sure your React app initializes EmailJS on application load. 
   Add this to your index.js or App.js:

```javascript
import emailjs from 'emailjs-com';

// Initialize EmailJS with your user ID
emailjs.init("YOUR_EMAILJS_USER_ID");
```

STEP 6: Testing
------------
1. Submit a test order on your application
2. Check that both emails are delivered:
   - One to the customer with payment instructions
   - One to your admin email with order details

EmailJS will track your email usage in their dashboard so you can monitor
how many emails you've sent from your monthly allocation.
*/
