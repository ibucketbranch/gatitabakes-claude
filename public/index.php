<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatita Bakes - Artisan Bread Orders</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>Gatita Bakes</h1>
            </div>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#products">Our Breads</a></li>
                <li><a href="#order">Order Now</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="home" class="hero">
            <h2>Welcome to Gatita Bakes</h2>
            <p>Artisan bread made with love and care</p>
        </section>

        <section id="products">
            <!-- Product listing will go here -->
        </section>

        <section id="order">
            <!-- Order form will go here -->
        </section>

        <section id="contact">
            <!-- Contact information will go here -->
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Gatita Bakes. All rights reserved.</p>
    </footer>

    <script src="js/main.js"></script>
</body>
</html> 