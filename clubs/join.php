<?php
    session_start();
    include("connection.php");

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id']; // Assuming you store user_id in session after login
        $club_id = $_POST['club_id']; // Get the club_id from the form

        // Check if the user is already a member of the club
        $checkQuery = "SELECT * FROM memberships WHERE user_id = ? AND club_id = ?";
        $stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $club_id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($res) > 0) {
            echo "You are already a member of this club.";
            header("Location: final.php");
        } else {
            // Insert the user into the club
            $insertQuery = "INSERT INTO memberships (user_id, club_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($stmt, "ii", $user_id, $club_id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "You have successfully joined the club!";
                header("Location: final.php");
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "You must be logged in to join a club.";
        header("Location: final.php");
    }
?>
