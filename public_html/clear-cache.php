<?php
/**
 * Project: Gatita Bakes Online Order System
 * Title: Cache Clearer
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2025-05-10
 */

// Clear browser cache with headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Generate unique timestamp for cache busting
$timestamp = time();

// Get the page to redirect to after clearing cache
$redirect = isset($_GET['to']) ? $_GET['to'] : 'new-design.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearing Cache - Gatita Bakes</title>
    <style>
        body {
            font-family: 'SF Pro Display', -apple-system, system-ui, sans-serif;
            background-color: #f8f3e8;
            color: #2c1810;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(139, 69, 19, 0.1);
        }
        h1 {
            color: #8b4513;
            margin-top: 0;
        }
        p {
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        a.button {
            display: inline-block;
            background: linear-gradient(145deg, #9b5a2a, #7d3d0a);
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        a.button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 69, 19, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cache Clearing Utility</h1>
        <p>This page helps clear your browser cache so you can see the latest design changes.</p>
        <p>The cache has been cleared for this session. Please click one of the buttons below to view the updated page:</p>
        
        <div class="buttons">
            <a href="order-form.php?clear=<?php echo $timestamp; ?>" class="button">Original Design</a>
            <a href="new-design.php?clear=<?php echo $timestamp; ?>" class="button">New Design</a>
        </div>
    </div>
</body>
</html> 