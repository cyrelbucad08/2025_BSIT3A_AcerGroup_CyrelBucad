<?php
// Include the database connection
include 'db.php';

// Handle search functionality
$search_results = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql = "SELECT * FROM homepage_content WHERE section = 'items' AND title LIKE '%$search_query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iPawnshop - Home</title>
    <link rel="stylesheet" href="home.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fdfdfd;
        }

        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #0e2f1c; /* Updated color */
            padding: 10px 20px;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar .search-bar {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 20px;
            padding: 5px 10px;
            width: 200px;
        }

        .navbar .search-bar input {
            border: none;
            outline: none;
            width: 100%;
            padding: 5px;
            font-size: 14px;
        }

        .navbar .search-bar button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            color: #4267B2;
        }

        .navbar .nav-icons {
            display: flex;
            gap: 20px;
        }

        .navbar .nav-icons a {
            color: white;
            text-decoration: none;
            font-size: 20px;
            position: relative;
        }

        .navbar .nav-icons a:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        .navbar .nav-icons a:hover {
            color: #f5cc59; /* Highlight on hover */
        }

        .navbar .profile-menu {
            position: relative;
        }

        .navbar .profile-menu .profile-icon {
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

        .navbar .profile-menu .profile-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .navbar .profile-menu .dropdown {
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

        .navbar .profile-menu .dropdown a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: black;
            font-size: 14px;
        }

        .navbar .profile-menu .dropdown a:hover {
            background-color: #f5f5f5;
        }

        .navbar .profile-menu.active .dropdown {
            display: block;
        }

        /* Slider Section */
        .slider {
            position: relative;
            width: 100%;
            height: 500px; /* Keep the slider height */
            overflow: hidden;
            background-color: #fdfdfd; /* Background color for empty space */
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            width: 100%;
            flex-shrink: 0;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fdfdfd; /* Background color for empty space */
        }

        .slide img {
            width: 100%; /* Stretch the image to fill the width of the slide */
            height: 100%; /* Stretch the image to fill the height of the slide */
            object-fit: cover; /* Ensure the image fills the slide while maintaining aspect ratio */
            object-position: center; /* Center the image within the slide */
        }

        .slider .button {
            position: absolute;
            bottom: 20px; /* Position the button inside the slider */
            left: 50%;
            transform: translateX(-50%);
            background-color: #f5cc59;
            color: #0e2f1;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            z-index: 2; /* Ensure the button is above the image */
        }

        .slider .button:hover {
            background-color: #d4a437;
        }

        /* Remove any margin or padding between sections */
        body, html {
            margin: 0;
            padding: 0;
        }

        .slider, .slides, .slide {
            margin: 0;
            padding: 0;
        }

        /* Navigation Arrows */
        .slider .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            z-index: 1000;
        }

        .slider .arrow.left {
            left: 10px;
        }

        .slider .arrow.right {
            right: 10px;
        }

        .slider .arrow:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        /* Items Section */
        .items-section {
            padding: 4rem 2rem;
            text-align: center;
            background-color: #d6af58;
        }

        .items-section h2 {
            font-size: 2rem;
            color: white;
            margin-bottom: 2rem;
        }

        .items-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 200px;
            cursor: pointer;
        }

        .item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .item p {
            margin: 1rem 0;
            font-size: 1.1rem;
            color: #333;
            font-weight: bold;
        }
        .estimator-form {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 1rem 2rem;
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 2rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(40,167,69,0.06);
            transition: box-shadow 0.3s, transform 0.3s, background 0.3s;
        }
        .estimator-form:hover {
            box-shadow: 0 8px 24px rgba(40,167,69,0.18), 0 1.5px 8px rgba(40,167,69,0.10);
            background: #f6fff8;
            transform: translateY(-4px) scale(1.015);
            border: 1.5px solid #28a745;
        }
        .estimator-form .form-row {
            display: contents;
        }
        .estimator-form label {
            align-self: center;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.3rem;
            text-align: left;      /* <-- Make label text left-aligned */
            padding-right: 0.5rem;
        }
        .estimator-form input[type="text"],
        .estimator-form input[type="number"],
        .estimator-form select,
        .estimator-form textarea,
        .estimator-form input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .estimator-form textarea {
            resize: vertical;
        }
        .estimator-form .form-row.buttons-row {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 2rem;
            gap: 1.5rem;
        }
        .estimator-form .form-row.buttons-row a,
        .estimator-form .form-row.buttons-row button {
            min-width: 140px;
            max-width: 200px;
            text-align: center;
        }
        @media (max-width: 600px) {
            .estimator-form {
                grid-template-columns: 1fr;
            }
            .estimator-form label {
                text-align: left;
                padding-right: 0;
            }
            .estimator-form .form-row.buttons-row {
                flex-direction: column;
                gap: 1rem;
            }
        }

        .estimator-form select:focus,
        .estimator-form input[type="text"]:focus,
        .estimator-form input[type="number"]:focus,
        .estimator-form textarea:focus {
            outline: 2px solid #d4a437;
            background-color: #fffde7;
            transition: background 0.2s, outline 0.2s;
        }
        .estimator-form input[type="file"]::-webkit-file-upload-button {
            background: #d4a437;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            cursor: pointer;
        }
        .estimator-form input[type="file"]::file-selector-button {
            background: #d4a437;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            cursor: pointer;
        }

        .estimator-form .form-row > * {
            transition: box-shadow 0.2s, background 0.2s, border-color 0.2s;
        }

        .estimator-form .form-row:hover > * {
            box-shadow: 0 2px 12px rgba(40,167,69,0.10);
            background: #f6fff8;
            border-color: #28a745;
        }

        /* Make Back and Estimate Now buttons hoverable */
        .estimator-form .form-row.buttons-row a.button,
        .estimator-form .form-row.buttons-row button.button {
            transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
        }

        .estimator-form .form-row.buttons-row a.button:hover {
            background: #555;
            color: #fff;
            box-shadow: 0 4px 16px rgba(40,167,69,0.15);
            transform: translateY(-2px) scale(1.04);
            text-decoration: none;
        }

        .estimator-form .form-row.buttons-row button.button:hover {
            background: #218838;
            color: #fff;
            box-shadow: 0 4px 16px rgba(40,167,69,0.15);
            transform: translateY(-2px) scale(1.04);
        }

        .items-section#items-section {
            background-color: #1d4b0b !important;
        }
        .items-section#items-section h2,
        .items-section#items-section p {
            color: #fff;
        }

        /* Move navigation icons to the right, beside the profile menu */
        .navbar .nav-right {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .footer {
      background-color: #1f5a22;
      color: #fff6db;
      padding: 40px 20px;
      margin-top: 50px;
    }

  .footer-container {
  max-width: 1200px;
  margin: auto;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 60px;
}

    .footer-section {
      flex: 1 1 250px;
    }

    .footer h3 {
      margin-bottom: 15px;
      color: #ffda8e;
    }

    .footer p, .footer a {
      color: #fff6db;
      text-decoration: none;
      line-height: 1.6;
      font-size: 15px;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    .footer-bottom {
      text-align: center;
      margin-top: 30px;
      border-top: 1px solid #fff6db33;
      padding-top: 15px;
      font-size: 14px;
    }
    @media (max-width: 768px) {
      .footer-container {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
    </style>
    <script>
        // Toggle profile dropdown visibility
        function toggleProfileMenu() {
            const profileMenu = document.querySelector('.profile-menu');
            profileMenu.classList.toggle('active');
        }

        // Close the dropdown if clicked outside
        document.addEventListener('click', function (event) {
            const profileMenu = document.querySelector('.profile-menu');
            if (!profileMenu.contains(event.target)) {
                profileMenu.classList.remove('active');
            }
        });

        let currentSlide = 0;
        let isDragging = false;
        let startPos = 0;
        let currentTranslate = 0;
        let prevTranslate = 0;
        let animationID;
        const slides = document.querySelectorAll('.slide');

        function showSlide(index) {
            const slidesContainer = document.querySelector('.slides');
            const totalSlides = slidesContainer.children.length;
            currentSlide = (index + totalSlides) % totalSlides;
            slidesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
        }

        function touchStart(index) {
            return function (event) {
                isDragging = true;
                startPos = getPositionX(event);
                animationID = requestAnimationFrame(animation);
                slides[index].classList.add('grabbing');
            };
        }

        function touchEnd() {
            isDragging = false;
            cancelAnimationFrame(animationID);
            const movedBy = currentTranslate - prevTranslate;

            if (movedBy < -100 && currentSlide < slides.length - 1) nextSlide();
            if (movedBy > 100 && currentSlide > 0) prevSlide();

            setPositionByIndex();
            slides.forEach(slide => slide.classList.remove('grabbing'));
        }

        function touchMove(event) {
            if (isDragging) {
                const currentPosition = getPositionX(event);
                currentTranslate = prevTranslate + currentPosition - startPos;
            }
        }

        function getPositionX(event) {
            return event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
        }

        function animation() {
            const slidesContainer = document.querySelector('.slides');
            slidesContainer.style.transform = `translateX(${currentTranslate}px)`;
            if (isDragging) requestAnimationFrame(animation);
        }

        function setPositionByIndex() {
            currentTranslate = currentSlide * -window.innerWidth;
            prevTranslate = currentTranslate;
            const slidesContainer = document.querySelector('.slides');
            slidesContainer.style.transform = `translateX(${currentTranslate}px)`;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const slidesContainer = document.querySelector('.slides');
            slidesContainer.addEventListener('mousedown', touchStart(0));
            slidesContainer.addEventListener('mouseup', touchEnd);
            slidesContainer.addEventListener('mousemove', touchMove);
            slidesContainer.addEventListener('mouseleave', touchEnd);

            slidesContainer.addEventListener('touchstart', touchStart(0));
            slidesContainer.addEventListener('touchend', touchEnd);
            slidesContainer.addEventListener('touchmove', touchMove);

            setInterval(nextSlide, 5000); // Auto-slide every 5 seconds
        });
        // Simple estimator logic
        const multipliers = {
            "18k": 1800,
            "22k": 2200,
            "24k": 2500
        };

        function updateEstimate() {
            const grams = parseFloat(document.getElementById('grams').value) || 0;
            const model = document.getElementById('model').value;
            let estimate = 0;
            if (grams > 0 && multipliers[model]) {
                estimate = grams * multipliers[model];
            }
            document.getElementById('estimateResult').textContent = "Estimated Value: ₱" + estimate.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
        }

        document.getElementById('grams').addEventListener('input', updateEstimate);
        document.getElementById('model').addEventListener('change', updateEstimate);
    </script>
</head>
<body>
    <!-- Navbar -->
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

        <!-- Notification Icon -->
        <a href="notification.php" style="color: white; font-size: 20px;" title="Notification">🔔</a>

        <!-- SANGLA NOW Button -->
        <button onclick="window.location.href='marketplace.php'" style="background-color: #f5cc59; color: #0e2f1c; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; font-weight: bold;">
            SANGLA NOW
        </button>

        <!-- Profile Menu -->
        <div class="profile-menu">
            <div class="profile-icon" onclick="toggleProfileMenu()">
                <img src="images/profile.png" alt="Profile">
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



    <!-- First Section: Slider -->
    <div class="slider">
        <div class="slides">
            <div class="slide">
                <img src="images/slider.png" alt="Slide 1">
            </div>
            <div class="slide">
                <img src="images/cover2.png" alt="Slide 2">
            </div>
            <div class="slide">
                <img src="images/cover3.png" alt="Slide 3">
            </div>
        </div>
        <button class="button" onclick="window.location.href='marketplace.php'">SANGLA NOW</button>
        <button class="arrow left" onclick="prevSlide()">&#10094;</button>
        <button class="arrow right" onclick="nextSlide()">&#10095;</button>
    </div>


        <!-- Sangla Estimator-->

  <section style="background-color: #f3cf7a; padding: 7rem 2rem;">
  <div style="display: flex; justify-content: center; align-items: normal; gap: 40px; flex-wrap: wrap;">

    <!-- Left Text -->
    <div style="text-align: right;">
      <h2 style="color: #1e460e; font-size: 40px; font-weight: bold;">sa iPawnShop</h2>
      <p style="font-style: italic; color: #8a5b1d; font-size: 28px;">
        Mabilis, Madali,<br />
        Maaasahan
      </p>
    </div>

    <!-- Center Estimator -->
    <div style="
  position: relative;
  width: 350px;
  height: 350px;
  border-radius: 25px;
  overflow: hidden;
  background-color: #fff6d5;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
">
  <!-- Background Image -->
  <img src="images/sanglaest.jpg" alt="Jewelry" style="
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 1
  ">

  <!-- Text Layer -->
  <div style="
    position: relative;
    z-index: 1.5;
    color: #1e460e;
    padding: 2rem;
    text-align: left;
  ">
    <h3 style="margin: 0; font-size: 40px;">
      <strong>SANGLA<br>ESTIMATOR</strong>
    </h3>
    <p style="font-size: 20px;">Estimate your jewelry's appraisal here →</p>
  </div>
</div>



    <!-- Right Buttons -->
<div style="display: flex; flex-direction: column; gap: 10px;">
  <!-- TUBO -->
  <div style="
    background-color: #bd8f13;
    color: #1e460e;
    padding: 2rem;
    border-radius: 15px;
    width: 120px;
    text-align: left;
  ">
    <div style="font-size: 28px; font-weight: 800;">TUBO</div>
    <small style="font-size: 18px;">Pay your monthly tubo here →</small>
  </div>

  <!-- TUBOS -->
  <div style="
    background-color: #bd8f13;
    color: #1e460e;
    padding: 2rem;
    border-radius: 15px;
    width: 120px;
    text-align: left;
  ">
    <div style="font-size: 28px; font-weight: 800;">TUBOS</div>
    <small style="font-size: 18px;">Pay your redemption amount here →</small>
  </div>
</div>


  </div>
</section>


    <!-- Second Section: Items We Accept -->
    <section class="items-section" id="items-section">
        <h2 style="color: #d6af58;">Items we Accept</h2>
        <div class="items-container">
            <div class="item" onclick="window.location.href='marketplace.php?category=necklace'">
                <img src="images/necklace.jpg" alt="Necklace">
                <p>Necklace</p>
            </div>
            <div class="item" onclick="window.location.href='marketplace.php?category=earrings'">
                <img src="images/earrings.jpg" alt="Earrings">
                <p>Earrings</p>
            </div>
            <div class="item" onclick="window.location.href='marketplace.php?category=ring'">
                <img src="images/ring.jpg" alt="Ring">
                <p>Ring</p>
            </div>
            <div class="item" onclick="window.location.href='marketplace.php?category=watch'">
                <img src="images/watch.jpg" alt="Watch">
                <p>Watch</p>
            </div>
            <div class="item" onclick="window.location.href='marketplace.php?category=bracelet'">
                <img src="images/bracelet.jpg" alt="Bracelet">
                <p>Bracelet</p>
            </div>
        </div>
    </section>

    <!-- Tutorial Section -->
<section style="padding: 4rem 2rem; background-color: #d6af58; text-align: center;">
  <h2 style="color: white;">How to Use iPawn</h2>
  <p style="color: white;">Watch our step-by-step guide and learn how to use the platform.</p>

  <div style="display: flex; justify-content: center; gap: 30px; margin-top: 2rem; flex-wrap: wrap;">
    <div style="position: relative; width: 200px; height: 200px; background-color: #bd8f13; border-radius: 15px; display: flex; align-items: flex-end; justify-content: center; padding-bottom: 30px;">
      <div style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); background-color: #1e460e; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 28px; font-weight: bold;">1</div>
      <div style="color: white; font-size: 12px;">Estimate Your Jewelry
Use our Sangla Estimator on the landing page to get an instant estimate of your jewelry's value.
Once you're ready, click “Sangla Now” to proceed.</div>
    </div>

    <div style="position: relative; width: 200px; height: 200px; background-color: #bd8f13; border-radius: 15px; display: flex; align-items: flex-end; justify-content: center; padding-bottom: 30px;">
      <div style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); background-color: #1e460e; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 28px; font-weight: bold;">2</div>
      <div style="color: white; font-weight: absolute; font-size: 12px;">Submit Appraisal Request
Log in or create an account to continue.
Fill out the online appraisal form and upload photos of your jewelry.
After submitting, just wait for a notification with your appraisal result, interest, and loan offer.</div>
    </div>

    <div style="position: relative; width: 200px; height: 200px; background-color: #bd8f13; border-radius: 15px; display: flex; align-items: flex-end; justify-content: center; padding-bottom: 30px;">
      <div style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); background-color: #1e460e; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 28px; font-weight: bold;">3</div>
      <div style="color: white; font-weight: absolute; font-size: 12px;">Accept & Visit the Branch
Review the offer, then click Accept if you agree to the terms.
A message will guide you to visit the nearest iPawnShop branch to verify your jewelry and receive your loan.
Once completed, track your transaction status anytime in your Sangla Dashboard.</div>
    </div>
  </div>
</section>


<!-- View Our Marketplace Section -->
<section style="padding: 4rem 2rem; background-color: #fdfdfd; text-align: center;">
    <h2 style="color: #0e2f1c;">View Our Marketplace</h2>
    <p style="color: #333;">Discover quality remata items at the best prices.</p>
    <button onclick="window.location.href='marketplace.php'" style="margin-top: 1rem; background-color: #f5cc59; color: #0e2f1c; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Visit Marketplace</button>
</section>

<!-- FAQs Section -->
<section style="padding: 4rem 2rem; background-color: #d6af58; text-align: center;">
    <h2 style="color: white;">Frequently Asked Questions</h2>
    <div style="max-width: 800px; margin: 2rem auto; text-align: left; background-color: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <p><strong>Q:</strong> How do I pawn an item?</p>
        <p><strong>A:</strong> Click on "Sangla Now" and follow the steps to submit your item details.</p>
        <hr>
        <p><strong>Q:</strong> How long does the appraisal take?</p>
        <p><strong>A:</strong> Appraisal usually takes less than 24 hours.</p>
        <hr>
        <p><strong>Q:</strong> What items can I pawn?</p>
        <p><strong>A:</strong> We accept necklace, earrings, rings, watch, and bracelet.</p>
    </div>
</section>

<!-- Footer -->

<footer class="footer">
  <div class="footer-container">
    
   <!-- Logo Section -->
    <div class="footer-section" style="flex: 1; display: flex; justify-content: flex-start;">
     <img src="images/logo1.jpg" alt="Footer Logo" style="width: 150px; height: 150px;">
    </div>


    <!-- About Us -->
    <div class="footer-section" style="flex: 1;">
      <h3>About Us</h3>
      <p>Trusted Pawnshop since 2025. We provide fair and fast loan services secured with valuable collaterals.</p>
    </div>

    <!-- Quick Links -->
    <div class="footer-section" style="flex: 1;">
      <h3>Quick Links</h3>
      <p><a href="home.php">Home</a></p>
      <p><a href="marketplace.php">Marketplace</a></p>
      <p><a href="branch.php">Branch</a></p>
      <p><a href="about.php">About Us</a></p>
    </div>

    <!-- Contact Info -->
    <div class="footer-section" style="flex: 1;">
      <h3>Contact Info</h3>
      <p>Email: support@ipawnshop.com</p>
      <p>Phone: 0907-536-5447</p>
      <p>Address: 123 iPawnshop Lane, Philippines</p>
    </div>

    <!-- Business Hours -->
    <div class="footer-section" style="flex: 1;">
      <h3>Business Hours</h3>
      <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
      <p>Saturday: 9:00 AM - 4:00 PM</p>
      <p>Sunday: Closed</p>
    </div>

  </div>

  <div class="footer-bottom">
    &copy; 2025 iPawnshop. All rights reserved.
  </div>
</footer>

</body>
</html>

    <!-- Search Results Section -->
    <?php if (!empty($search_results)): ?>
        <div class="search-results">
            <h2>Search Results</h2>
            <div class="items-container">
                <?php foreach ($search_results as $item): ?>
                    <div class="item">
                        <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['title']; ?>" onclick="window.location.href='<?php echo $item['link_url']; ?>'">
                        <p><?php echo $item['title']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>