/**
 * Project: Gatita Bakes Online Order System
 * Title: footer.php
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2024-06-09
 */
<?php
// Get current year for copyright
$current_year = date('Y');
?>
    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-section">
                <p class="copyright">&copy; <?php echo $current_year; ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/our-artisan-way">Our Artisan Way</a></li>
                    <li><a href="/test.php">Order Now</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <ul>
                    <li>Email: <?php echo SITE_EMAIL; ?></li>
                    <li>Venmo: <?php echo VENMO_HANDLE; ?></li>
                </ul>
            </div>
        </div>
    </footer>

    <style>
        .site-footer {
            background: #f5f5f5;
            padding: 40px 20px;
            margin-top: 60px;
            border-top: 1px solid #e0e0e0;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .footer-section h4 {
            color: #8b4513;
            margin-bottom: 15px;
            font-size: 1.1em;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-section ul li {
            margin-bottom: 8px;
        }

        .footer-section ul li a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: #8b4513;
        }

        .copyright {
            color: #666;
            font-size: 0.9em;
        }

        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-section {
                margin-bottom: 20px;
            }
        }
    </style>
</body>
</html> 