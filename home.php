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

    <!-- Sangla Estimator Section -->
    <section style="padding: 4rem 2rem; background-color: #fdfdfd; text-align: center;">
     <h2 style="color: #0e2f1c;">Sangla Estimator</h2>
    <p style="color: #333;">Quickly estimate the value of your item before pawning.</p>
    <button onclick="window.location.href='estimator.php'" style="margin-top: 1rem; background-color: #0e2f1c; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Try Now</button>
    </section>

    <!-- Second Section: Items We Accept -->
    <section class="items-section" id="items-section">
        <h2 style="color: #0e2f1c;">Items we Accept</h2>
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
    <video width="320" height="240" controls style="margin-top: 1rem;">
        <source src="tutorial.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
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