<?php
$name = "";
$email = "";
$pass = "";
$id = "";
$hashedPassword = "";
$_SERVER['Email'] = "";
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("connection.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = filter_var(trim($_POST['Email']), FILTER_SANITIZE_EMAIL);
    $pass = trim($_POST['pass']);
    
    if (empty($email) || empty($pass)) {
        echo '<div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                <strong>Alert!</strong> Please enter both an email and a password.
              </div>';
    } else {
        $query = "SELECT email FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo '<div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                    <strong>Alert!</strong> Email already exists.
                  </div>';
        } else {
            $_SERVER['Email'] = $email;
            // Hash the password
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);


            // Debugging: Check the hashed password
            echo "Hashed Password: $hashedPassword<br>";

            if (mysqli_stmt_execute($stmt)) {
                echo '<div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                        <strong>Success!</strong> Registration successful.
                      </div>';
                header("Location: demologin.php");
            } else {
                echo '<div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                        <strong>Error!</strong> Registration failed: ' . mysqli_error($conn) . '
                      </div>';
            }
        }

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
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Register</title>
</head>
<body>
    <section class="page">
        <div class="cont">
            <h2 class="forhead">Register</h2>
            <form method="post" class="forform">
                <div class="input-box">
                    <label for="name" class="forlabel">Name</label><br>
                    <input type="text" name="name" id="name" class="box" required><br>
                </div>
                <div class="input-box">
                    <label for="Email" class="forlabel">Email</label><br>
                    <input type="email" name="Email" id="Email" class="box" required><br>
                </div>
                <div class="input-box">
                    <label for="pass" class="forlabel">Password</label><br>
                    <input type="password" name="pass" id="pass" class="box" required><br>
                </div>
                <button type="submit" class="fortry">Register</button>
            </form>
            <div class="">
                <p>Already have an account?<a href="demologin.php" class="next">Log In</a></p>
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