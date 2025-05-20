<?php
// Include the database connection
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branches</title>

    <!-- AOS & Feather Icons -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1d4b0b;
            color: white;
        }

        /* Navbar */
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

        /* Branch Section */
        .branch-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 4rem 2rem;
            min-height: 100vh;
        }

        .branch-section h1 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: #ffc300;
            font-weight: 800;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        .branch-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            max-width: 1200px;
            width: 100%;
        }

        .branch {
            position: relative;
            background-color: rgba(245, 182, 15, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 300px;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .branch:hover {
            transform: scale(1.06);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }

        .branch img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.5;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .branch:hover img {
            opacity: 0.8;
            transform: scale(1.1);
        }

        .branch-label {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.5);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 1.2rem;
            color: white;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .branch:hover .branch-label {
            background: rgba(0, 0, 0, 0.7);
            transform: translateX(-50%) translateY(-5px);
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
            <input type="text" name="search" placeholder="Search branches..." value="">
            <button type="submit">🔍</button>
        </form>

        <!-- Navigation Icons -->
        <div class="nav-icons">
            <a href="home.php" data-tooltip="Home">🏠</a>
            <a href="marketplace.php" data-tooltip="Marketplace">🛒</a>
            <a href="branch.php" data-tooltip="Branches">📍</a>
            <a href="about.php" data-tooltip="About">ℹ️</a>
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

    <!-- Branch Section -->
    <section class="branch-section">
        <h1 data-aos="fade-down"><span style="color: #ffc300;">🌿</span> Our Branches</h1>

        <div class="branch-container">
            <div class="branch" data-aos="zoom-in" onclick="location.href='ligao.php'">
                <img src="images/ligao.jpg" alt="Polangui Branch">
                <div class="branch-label">Polangui</div>
            </div>
            <div class="branch" data-aos="zoom-in" data-aos-delay="100" onclick="location.href='tabaco.php'">
                <img src="images/tabaco.jpg" alt="Libon Branch">
                <div class="branch-label">Libon</div>
            </div>
            <div class="branch" data-aos="zoom-in" data-aos-delay="200" onclick="location.href='legazpi.php'">
                <img src="images/legazpi.jpg" alt="Ligao City Branch">
                <div class="branch-label">Ligao City</div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1000, once: true });
        feather.replace();
    </script>

</body>
</html>
