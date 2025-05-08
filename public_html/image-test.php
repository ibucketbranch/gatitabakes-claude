<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simple HTML structure
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Test Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }
        .test-image {
            max-width: 100%;
            height: auto;
            border: 2px solid #ccc;
            margin: 20px 0;
        }
        .debug-info {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h1>Image Test Page</h1>
    
    <div class="debug-info">
        <h3>Debug Information:</h3>
        <p>Current directory: <?php echo __DIR__; ?></p>
        <p>Image path: <?php echo __DIR__ . '/images/Plain-Sourdough-Loaf.jpg'; ?></p>
        <p>File exists: <?php echo file_exists(__DIR__ . '/images/Plain-Sourdough-Loaf.jpg') ? 'Yes' : 'No'; ?></p>
    </div>

    <h2>Test Image 1 (Direct path):</h2>
    <img src="images/Plain-Sourdough-Loaf.jpg" alt="Plain Sourdough Loaf" class="test-image">

    <h2>Test Image 2 (Full URL):</h2>
    <img src="https://darkseagreen-ferret-989166.hostingersite.com/images/Plain-Sourdough-Loaf.jpg" 
         alt="Plain Sourdough Loaf" class="test-image">

    <h2>Test Image 3 (Absolute path):</h2>
    <img src="/images/Plain-Sourdough-Loaf.jpg" alt="Plain Sourdough Loaf" class="test-image">
</body>
</html> 