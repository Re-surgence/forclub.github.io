<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['leave_club'])) {
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session
    $club_id = $_POST['club_id']; // Club ID from form

    // Use a prepared statement to delete the user from the club
    $query = "DELETE FROM memberships WHERE user_id = ? AND club_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $club_id);
        mysqli_stmt_execute($stmt);

        // Check if a row was affected (meaning the user left the club)
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "You have successfully left the club.";
            header("Location: final.php");
        } else {
            echo "Failed to leave the club or you're not a member.";
            header("Location: final.php");
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare the query.";
        header("Location: final.php");
    }
}
?>
