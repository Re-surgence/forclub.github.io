<?php
    session_start();
    include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="forabout.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>About Us</title>
</head>
<body>
    <section class="header">
        <nav>
            <a href="#"><img src="images/logo.png" alt="logo"></a>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-times" aria-hidden="true" onclick="hidemenu()"></i>
                <ul>
                    <li><a href="try.php">Home</a></li>
                    <li><a href="curabu.php">Clubs</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="clubs/logout.php">Logout</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showmenu()"></i>
        </nav>
    </section>
    <div class="text-box">
        <h1>About Us</h1>
    </div>
    <section class="forabout">
        <h2>About Us</h2>
        <p>Welcome to the official Club Membership Management System of the National Institute of Technology (NIT) Sikkim! Our platform is designed to streamline and enhance the experience of managing and participating in clubs across our vibrant campus community.

            At NIT Sikkim, we believe that clubs and societies are integral to personal growth, leadership development, and fostering collaboration among students. Our platform serves as a central hub for students, faculty, and club administrators to easily manage memberships, organize events, and engage in a wide array of activities.
            We are committed to ensuring that every student at NIT Sikkim has the opportunity to get involved and make the most of their college experience. Join us, and be part of a thriving, dynamic community that celebrates diversity, passion, and innovation!

        </p>
        <form action="curabu.php"><button type="submit" class="butt">Join a Club</button></form>
    </section>
    <script>
        let navLinks = document.getElementById("navLinks");
        function showmenu(){
            navLinks.style.right = "0";
        }
        function hidemenu(){
            navLinks.style.right = "-200px";
        }
    </script>
</body>
</html>