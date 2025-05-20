<?php
// filepath: c:\xampp\htdocs\Prompting\about.php

// Include the database connection if needed
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: #ffc300;
            --secondary-color: forestgreen;
            --accent-yellow: #ffdd57;
            --accent-green: #a0c334;
            --background-light: #f3f4f6;
            --background-gradient: linear-gradient(135deg, #a0c334, #ffc300);
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--background-light);
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #0e2f1c;
            padding: 10px 20px;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 20px;
            padding: 5px 10px;
            width: 200px;
        }

        .search-bar input {
            border: none;
            outline: none;
            width: 100%;
            padding: 5px;
            font-size: 14px;
        }

        .search-bar button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            color: #4267B2;
        }

        .nav-icons {
            display: flex;
            gap: 20px;
        }

        .nav-icons a {
            color: white;
            text-decoration: none;
            font-size: 20px;
        }

        .nav-icons a:hover {
            color: #f5b60f;
        }

        .profile-menu {
            position: relative;
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            overflow: hidden;
        }

        .profile-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dropdown {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background-color: white;
            color: black;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            z-index: 1000;
        }

        .dropdown a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: black;
            font-size: 14px;
        }

        .dropdown a:hover {
            background-color: #f5f5f5;
        }

        .profile-menu.active .dropdown {
            display: block;
        }

        .about-section {
            padding: 6rem 2rem;
            text-align: center;
            background-color: var(--primary-color);
            color: white;
        }

        .creators-section {
            padding: 6rem 2rem;
            text-align: center;
            background-color: var(--secondary-color);
            color: white;
        }

        .creators-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 2rem;
            justify-items: center;
        }

        .creator-container {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            width: 100%;
            max-width: 300px;
        }

        .creator-container:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .creator-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .creator-container:hover img {
            opacity: 0.8;
            transform: scale(1.1);
        }

        .creator-details {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .creator-container:hover .creator-details {
            opacity: 1;
            transform: scale(1);
        }

        .creator-details h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .creator-details p {
            font-size: 1rem;
            margin: 0.2rem 0;
        }
    </style>
    <script>
        // Profile dropdown toggle
        function toggleProfileMenu() {
            const profileMenu = document.querySelector('.profile-menu');
            profileMenu.classList.toggle('active');
        }

        // Close profile menu if clicked outside
        document.addEventListener('click', function (event) {
            const profileMenu = document.querySelector('.profile-menu');
            if (!profileMenu.contains(event.target)) {
                profileMenu.classList.remove('active');
            }
        });
    </script>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <!-- Search Bar -->
        <form class="search-bar" method="GET" action="">
            <input type="text" name="search" placeholder="Search..." value="">
            <button type="submit">🔍</button>
        </form>

        <!-- Navigation Icons -->
        <div class="nav-icons">
            <a href="home.php" data-tooltip="Home">Home</a>
            <a href="marketplace.php" data-tooltip="Marketplace">Marketplace</a>
            <a href="branch.php" data-tooltip="Branches">Branch</a>
            <a href="about.php" data-tooltip="About">About Us</a>
        </div>

        <!-- Profile Menu -->
        <div class="profile-menu">
            <div class="profile-icon" onclick="toggleProfileMenu()">
                <img src="profile.jpg" alt="Profile">
            </div>
            <div class="dropdown">
                <a href="profile.php">Profile</a>
                <a href="transactions.php">Transactions</a>
                <a href="loan.php">Loan</a>
                <a href="payments.php">Payments</a>
                <a href="sss.php">Log Out</a>
            </div>
        </div>
    </div>

    <!-- About Us Section -->
    <section class="about-section">
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 2rem; max-width: 1200px; margin: 0 auto;">
            <!-- Description -->
            <div style="flex: 1; text-align: left;">
                <h1 class="text-5xl font-extrabold mb-6">About Us</h1>
                <p class="text-lg leading-relaxed">
                    Welcome to iPawnshop, your modern and secure digital partner in pawn transactions. We are committed to transforming traditional pawnshop operations into a seamless, transparent, and customer-friendly experience. Our system empowers both customers and staff with real-time tracking, efficient item management, secure loan processing, and easy-to-use interfaces. At iPawnshop, we value trust, security, and innovation. Whether you're pawning, redeeming, or checking transaction history, we’re here to make your journey simple and secure. Let’s make smart pawning accessible to everyone—digitally.
                </p>
            </div>
            <!-- Logo Image -->
            <div style="flex: 1; text-align: center; position: relative; top: -20px;">
                <img src="images/about.png" alt="iPawnshop Logo" style="max-width: 100%; height: auto; margin-left: 125px;">
            </div>
        </div>
    </section>

    <!-- Contact and Social Media Section -->
    <section class="contact-social-section" style="background-color: var(--background-light); padding: 4rem 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 2rem; max-width: 1200px; margin: 0 auto;">
            <!-- Contact Details -->
            <div style="flex: 1; text-align: left; margin-left: 50px;">
                <h2 class="text-3xl font-semibold mb-4">Contact Details</h2>
                <p><strong>Phone:</strong> +1 800 123 4567</p>
                <p><strong>Email:</strong> support@ipawnshop.com</p>
                <p><strong>Address:</strong> 123 Pawnshop Lane, Cityville, Country</p>
                <p><strong>Working Hours:</strong> Mon-Fri, 9:00 AM - 6:00 PM</p>
            </div>
            <!-- Follow Us on Social Media -->
            <div style="flex: 1; text-align: left; margin-left: 300px;">
                <h2 class="text-3xl font-semibold mb-4">Follow Us on Social Media</h2>
                <p>Stay connected with us:</p>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="https://facebook.com" target="_blank" style="color: var(--primary-color); text-decoration: none;">Facebook</a></li>
                    <li><a href="https://twitter.com" target="_blank" style="color: var(--primary-color); text-decoration: none;">Twitter</a></li>
                    <li><a href="https://instagram.com" target="_blank" style="color: var(--primary-color); text-decoration: none;">Instagram</a></li>
                    <li><a href="https://linkedin.com" target="_blank" style="color: var(--primary-color); text-decoration: none;">LinkedIn</a></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Creators Section -->
    <section class="creators-section">
        <h2 class="text-4xl font-semibold">Meet the Creators</h2>
        <div class="creators-grid">
            <!-- Creator 1 -->
            <div class="creator-container">
                <img src="images/bea2.jpg" alt="Creator 1">
                <div class="creator-details">
                    <h3>Bea Ramos</h3>
                    <p>Contact: 1234567890</p>
                    <p>Email: ramos@example.com</p>
                </div>
            </div>
            <!-- Creator 2 -->
            <div class="creator-container">
                <img src="images/jed.jpg" alt="Creator 2">
                <div class="creator-details">
                    <h3>Jed Ismael Polong</h3>
                    <p>Contact: 09292222834</p>
                    <p>Email: polong@example.com</p>
                </div>
            </div>
            <!-- Creator 3 -->
            <div class="creator-container">
                <img src="images/Cyril.jpg" alt="Creator 3">
                <div class="creator-details">
                    <h3>Cyril Bucad</h3>
                    <p>Contact: 1122334455</p>
                    <p>Email: bucad@example.com</p>
                </div>
            </div>
            <!-- Creator 4 -->
            <div class="creator-container">
                <img src="images/alex.jpg" alt="Creator 4">
                <div class="creator-details">
                    <h3>Alexa Conception</h3>
                    <p>Contact: 2233445566</p>
                    <p>Email: conception@example.com</p>
                </div>
            </div>
            <!-- Creator 5 -->
            <div class="creator-container">
                <img src="images/daisy.webp" alt="Creator 5">
                <div class="creator-details">
                    <h3>Daisy Barce</h3>
                    <p>Contact: 3344556677</p>
                    <p>Email: barce@example.com</p>
                </div>
            </div>
            <!-- Creator 6 -->
            <div class="creator-container">
                <img src="images/Jhana.jpg" alt="Creator 6">
                <div class="creator-details">
                    <h3>Jhana Raquid</h3>
                    <p>Contact: 4455667788</p>
                    <p>Email: raquid@example.com</p>
                </div>
            </div>
            <!-- Empty Slots for 3x3 Grid -->
            <div class="creator-container"></div>
            <div class="creator-container"></div>
            <div class="creator-container"></div>
        </div>
    </section>
</body>
</html>