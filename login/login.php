<?php
// Include the database connection
include("connection.php");
session_set_cookie_params([
    'path' => '/',  // Ensures the session cookie is available across all directories
    'httponly' => true,  // Mitigates XSS risks by preventing JavaScript access to the session ID
]);
session_start();


// Start PHP session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and fetch input
    $email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
    $pass = $_POST['pass'];

    // Check for empty inputs
    if (empty(trim($email)) || empty(trim($pass))) {
        echo '<div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                <strong>Alert!</strong>Please enter something.
            </div>';

    } else {
        // Prepare SQL query to fetch the password for the entered email
        $query = "SELECT Password FROM members WHERE Email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        // Check if email exists
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Verify the password
            if (password_verify($pass, $row['Password'])) {
                // Set session and redirect to another page
                $_SESSION['Email'] = $email;
                header("Location: try.html");
                exit();
            } else {
                echo '<div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                        <strong>ALert!</strong>Invalid Password.
                    </div>';
            }
        } else {
            echo '<div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                    <strong>ALert!</strong>No user found with this email.
                </div>';
        }

        // Close statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="forlogin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <section class="page">
        <div class="cont">
            <h2 class="forhead">Welcome back!</h2>
            <form method="post" action="../try.php" class="forform">
                <div class="input-box">
                    <label for="Email" class="forlabel">Email</label><br>
                    <input type="email" name="Email" id="Email" class="box" required><br>
                </div>
                <div class="input-box">
                    <label for="pass" class="forlabel">Password</label><br>
                    <input type="password" name="pass" id="pass" class="box" required><br>
                </div>
                <button type="submit" class="fortry">Log In</button>
            </form>
            <div class="foot">
                <p>Don't have an account? <a href="index.php" class="next">Register here.</a></p>
            </div>
        </div>
    </section>
</body>
</html>
<script>
// Get all elements with class="closebtn"
var close = document.getElementsByClassName("closebtn");
var i;

// Loop through all close buttons
for (i = 0; i < close.length; i++) {
  // When someone clicks on a close button
  close[i].onclick = function(){

    // Get the parent of <span class="closebtn"> (<div class="alert">)
    var div = this.parentElement;

    // Set the opacity of div to 0 (transparent)
    div.style.opacity = "0";

    // Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
    setTimeout(function(){ div.style.display = "none"; }, 600);
  }
}
</script>
