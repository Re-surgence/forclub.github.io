<?php
// Include the database connection
include("connection.php");

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
        $query = "SELECT password FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if email exists
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Verify the password
            if (password_verify($pass, $row['password'])) {
                // Set session and redirect to another page
                $_SESSION['Email'] = $email;
                $query = "SELECT user_id FROM users WHERE email = '$email'";
                $res = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($res);
                $_SESSION['user_id'] =  $row['user_id'];
                header("Location: ../try.php");
                exit();
            } else {
                echo '<div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                        <strong>Alert!</strong>Invalid Password.
                    </div>';
            }
        } else {
            echo '<div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                    <strong>Alert!</strong>No user found with this email.
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
            <!-- Keep the form action pointing to the same page for correct session handling -->
            <form method="post" class="forform">
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
                <p>Don't have an account? <a href="demoregister.php" class="next">Register here.</a></p>
            </div>
        </div>
    </section>
</body>
</html>
<script>
// Same script for handling the close button for alerts
var close = document.getElementsByClassName("closebtn");
for (var i = 0; i < close.length; i++) {
    close[i].onclick = function() {
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function(){ div.style.display = "none"; }, 600);
    }
}
</script>
