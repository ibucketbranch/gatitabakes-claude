<?php
/**
 * Project: Gatita Bakes Online Order System
 * Title: Clear Cache
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2025-09-05
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clear Browser Cache - Gatita Bakes</title>
    <style>
        body {
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #2C1810;
            background-color: #FAF6F0;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(139, 69, 19, 0.08);
            margin-top: 50px;
        }
        h1 {
            color: #8B4513;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background: #8B4513;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            margin-top: 20px;
        }
        .btn:hover {
            background: #6d370f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Clear Browser Cache</h1>
        <p>If you're not seeing the latest design changes on the order form, it might be due to your browser caching old files.</p>
        <p>Try these options:</p>
        <ol>
            <li>Use the links below to view the order forms with cache-busting parameters</li>
            <li>Press Ctrl+F5 (Windows) or Cmd+Shift+R (Mac) to force a hard refresh</li>
            <li>Clear your browser cache through your browser settings</li>
        </ol>
        
        <a href="order-form.php?nocache=<?php echo time(); ?>" class="btn">View Original Design</a>
        <a href="new-design.php?nocache=<?php echo time(); ?>" class="btn">View New Design</a>
    </div>
</body>
</html> 