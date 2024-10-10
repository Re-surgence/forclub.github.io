<?php
    session_start();
    include("connection.php");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="forclub.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>

</head>
<body>
    <section class="header">
        <nav>
            <img src="images/logo.png" alt="logo">
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
        <div class="text-box">
            <h2>Clubs</h2>
        </div>
    </section>
    <section class="vclub">
        <div class="card-container">
            <?php
              $res = mysqli_query($conn, "SELECT * FROM clubs");
              while ($row = mysqli_fetch_assoc($res)) {
                  $clubName = strtolower($row['club_name']); 
                  echo '<div class="cards">
                          <img src="images/' . $row['image_dir'] . '" alt="banner" style="padding-bottom: 10px;width: 100%; height: 250px; object-position:top;height: 250px; object-fit:cover;">
                          <h2>' . htmlspecialchars($row['club_name']) . '</h2>
                          <form method="POST" action="clubs/final.php">
                              <input type="hidden" name="club_id" value="' . $row['club_id'] . '">
                              <button type="submit" class="butt" style="color:white;text-decoration:none;">Join</button>
                          </form>
                        </div>';
              }               
            ?>
        </div>
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