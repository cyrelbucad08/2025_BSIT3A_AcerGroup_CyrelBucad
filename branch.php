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
            font-family: Arial, sans-serif;
            font-weight: normal;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 4rem 2rem;
            min-height: 100vh;
        }

        .branch-section h1 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: #f5cc59;
            font-weight: 700;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        .branch-container {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: stretch;
    gap: 20px;
    flex-wrap: nowrap;
}



.branch {
    flex: 0 0 auto; /* ensures each branch stays fixed width */
    width: 300px;
    height: 200px;
    position: relative;
    background-color: rgba(245, 182, 15, 0.8);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

.branch .hover-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    padding: 8px 16px;
    font-size: 1rem;
    font-weight: bold;
    opacity: 0;
    transition: opacity 0.3s ease;
    text-align: center;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    border-radius: 8px;
    text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
}



.branch:hover .hover-text {
    opacity: 0;
    opacity: 1;
}

        .branch:hover {
            transform: scale(1.06);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }

        .branch img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: filter 0.3s ease, transform 0.3s ease;
    filter: none; /* Start clear */
}

.branch:hover img {
    filter: blur(3px); /* Becomes blurry on hover */
    transform: scale(1.05);
}


.branch-label {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 8px 16px;
    font-size: 1.8rem;
    color: white;
    font-weight: bold;
    text-shadow: 0 0 5px rgba(0, 0, 0, 0.5); /* slight glow for visibility */
    backdrop-filter: blur(4px); /* background blur effect */
    -webkit-backdrop-filter: blur(4px); /* Safari support */
    border-radius: 8px;
    transition: opacity 0.3s ease;
    opacity: 1;
}



        .branch:hover .branch-label {
            opacity: 0;
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
    <!-- Left Logo/Brand (Optional) -->
    <div style="color: #f5cc59; font-weight: bold; font-size: 1.2rem;">iPawnshop</div>

    <!-- Right Navigation -->
    <div style="display: flex; align-items: center; gap: 30px;">
        <!-- Text Navigation -->
        <a href="home.php" style="color: white; text-decoration: none; font-size: 16px;">Home</a>
        <a href="marketplace.php" style="color: white; text-decoration: none; font-size: 16px;">Marketplace</a>
        <a href="branch.php" style="color: white; text-decoration: none; font-size: 16px;">Branches</a>
        <a href="about.php" style="color: white; text-decoration: none; font-size: 16px;">About Us</a>

        <!-- Cart Icon -->
        <a href="cart.php" style="color: white; font-size: 20px;" title="Cart">🛒</a>

        <!-- SANGLA NOW Button -->
        <button onclick="window.location.href='marketplace.php'" style="background-color: #f5cc59; color: #0e2f1c; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; font-weight: bold;">
            SANGLA NOW
        </button>

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
</div>


    <!-- Branch Section -->
<section class="branch-section">
    <h1 data-aos="fade-down">Our Branches</h1>

    <div class="branch-container">
        <!-- Polangui -->
        <div class="branch" data-aos="zoom-in" onclick="location.href='ligao.php'">
            <img src="images/polangui.jpg" alt="Polangui Branch">
            <div class="branch-label">Polangui</div>
            <div class="hover-text">Pluto Street, Centro Occidental, Polangui, Albay</div>
        </div>

        <!-- Libon -->
        <div class="branch" data-aos="zoom-in" data-aos-delay="100" onclick="location.href='tabaco.php'">
            <img src="images/libon.jpg" alt="Libon Branch">
            <div class="branch-label">Libon</div>
            <div class="hover-text">Zone 7 Del Rosario, Libon, Albay</div>
        </div>

        <!-- Ligao City -->
        <div class="branch" data-aos="zoom-in" data-aos-delay="200" onclick="location.href='legazpi.php'">
            <img src="images/ligao.jpg" alt="Ligao City Branch">
            <div class="branch-label">Ligao City</div>
            <div class="hover-text">Zone 1 Tuburan, Ligao City, Albay</div>
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
