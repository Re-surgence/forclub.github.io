<?php
    session_Start();
    include("connection.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_content'])) {
        $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
        $user_id = $_SESSION['user_id'];
        $club_id = $_POST['club_id'];
    
        if (!empty($post_content)) {
            $query = "INSERT INTO posts (user_id, club_id, post_content) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "iis", $user_id, $club_id, $post_content);
            mysqli_stmt_execute($stmt);
            header("Location: final.php");
        }
    }
    
?>