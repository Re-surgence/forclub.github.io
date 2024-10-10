<?php
    session_start();
    include("connection.php");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $_SESSION['club_id'] = $_POST['club_id'];
    }
    $club_id = $_SESSION['club_id'];
    $query = "SELECT * FROM clubs WHERE club_id ='$club_id' ";
    $res = mysqli_query($conn, $query);
    
    $row = mysqli_fetch_assoc($res);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="clickclub.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Basketball Club</title>
</head>
<body>
    <section class="root">
        <nav>
            <img src="../images/logo.png" alt="logo">
            <div class="nav-links" id="navLinks">
                <i class="fa fa-times" aria-hidden="true" onclick="hidemenu()"></i>
                <ul>
                    <li><a href="../try.php">Home</a></li>
                    <li><a href="../curabu.php">Clubs</a></li>
                    <li><a href="../about.php">About Us</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showmenu()"></i>
        </nav>

        <div class="page">
            <div class="forpage">
                <div class="banner">
                <img src="../images/<?php echo $row['image_dir']; ?>" alt="banner" class="adobanner">
                </div>

                <div class="sub-profile">
                    <div class="forprofilepic">
                    <img src="../images/<?php echo $row['profile_img_dir']; ?>" alt="profile pic" class="profilepic">
                    </div>
                    <div class="fordescription">
                        <?php echo "<h2>" . $row['club_name'] . " Club</h2>"; ?>
                        <?php echo "<h5>" . $row['description'] . "</h5>"; ?>
                        <form method="POST" action="join.php" class="but">
                            <input type="hidden" name="club_id" value="<?php echo $club_id; ?>">
                            <button type="submit" class="join">Join Club</button>
                        </form>
                        <form method="POST" action="leave.php" class="but">
                            <input type="hidden" name="club_id" value="<?php echo $club_id; ?>">
                            <button type="submit" class="join" name="leave_club">Leave Club</button>
                        </form>
                    </div>
                </div>

                <div class="tabs">
                    <button class="tablink" onclick="openPage('Feed', this, 'rgb(90,90,90)')">Feed</button>
                    <button class="tablink" onclick="openPage('Members', this, 'rgb(90,90,90)')" id="defaultOpen">Members</button>

                    <div id="Feed" class="tabcontent">
                        <form class="forpost" method="POST" action="club_page.php">
                            <textarea class="fortext" name="post_content" placeholder="Write your post..."></textarea>
                            <input type="hidden" name="club_id" value="<?php echo $club_id; ?>">
                            <button type="submit" class="join" >Post</button>
                        </form>
                        <?php
                            $query = "SELECT p.post_content, p.post_time, u.name 
                            FROM posts p 
                            JOIN users u ON p.user_id = u.user_id 
                            WHERE p.club_id = ? 
                            ORDER BY p.post_time DESC";
                            $stmt = mysqli_prepare($conn, $query);
                            mysqli_stmt_bind_param($stmt, "i", $club_id);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            while ($row = mysqli_fetch_assoc($result)) {
                            echo "<div class='post'>";
                            echo "<p><strong>" . htmlspecialchars($row['name']) . ":</strong> " . htmlspecialchars($row['post_content']) . "</p>";
                            echo "<small>" . $row['post_time'] . "</small>";
                            echo "</div>";
                            }
                        ?>
                    </div>

                    <div id="Members" class="tabcontent">
                        <h3>Members:</h3>
                        <!-- Your PHP code for displaying members goes here -->
                         <table class="table" style="text-align: center;">
                            <thead>
                                <tr>
                                    <td><h2>Serial Number </h2></td>
                                    <td><h2>Name </h2></td>
                                    <td><h2>Email </h2></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "SELECT u.user_id, u.name, u.email 
                                            FROM memberships m
                                            JOIN users u ON m.user_id = u.user_id
                                            WHERE m.club_id = ?";

                                    // Prepare and execute the query
                                    $stmt = mysqli_prepare($conn, $query);
                                    mysqli_stmt_bind_param($stmt, 'i', $club_id);
                                    mysqli_stmt_execute($stmt);
                                    $res = mysqli_stmt_get_result($stmt);

                                    // Check if the query returned any rows
                                    if (mysqli_num_rows($res) > 0) {
                                        // Fetch and display all members in an HTML table
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['user_id'] . "</td>";
                                            echo "<td>" . $row['name'] . "</td>";
                                            echo "<td>" . $row['email'] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "No members found for this club.";
                                    }
                                ?>
                            </tbody>
                         </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Place script at the end of the body -->
<script>
    // Function to toggle menu visibility
    let navLinks = document.getElementById("navLinks");

    function showmenu() {
        navLinks.style.right = "0";
    }

    function hidemenu() {
        navLinks.style.right = "-200px";
    }

    // Function to switch between tab content
    function openPage(pageName, elmnt, color) {
        var i, tabcontent, tablinks;

        // Hide all elements with class="tabcontent"
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Remove background color of all tablinks
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "";
            tablinks[i].classList.remove("active"); // Remove active class
        }

        // Show the specific tab content
        document.getElementById(pageName).style.display = "block";

        // Add background color to the clicked button and set active class
        elmnt.style.backgroundColor = color;
        elmnt.classList.add("active"); // Add active class
    }

    // Auto-click the default tab to display it on load
    document.getElementById("defaultOpen").click();
</script>
</body>
</html>
