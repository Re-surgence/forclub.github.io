<?php
    include("connection.php");

    if (isset($_POST['submit'])) {
        // Handling the main club banner image
        $banner_name = $_FILES['image']['name'];
        $banner_tempname = $_FILES['image']['tmp_name'];
        $banner_folder = 'images/' . $banner_name;

        // Handling the profile image
        $profile_name = $_FILES['profileimage']['name'];
        $profile_tempname = $_FILES['profileimage']['tmp_name'];
        $profile_folder = 'images/' . $profile_name;

        // Retrieve other form data
        $club_name = $_POST['club_name'];
        $description = $_POST['description'];

        // Insert data into the database
        $query = mysqli_query($conn, "INSERT INTO clubs (club_name, image_dir, profile_img_dir, description) VALUES ('$club_name', '$banner_name', '$profile_name', '$description')");

        // Check if the query was successful
        if ($query) {
            // Move both images to the 'images' folder
            if (move_uploaded_file($banner_tempname, $banner_folder) && move_uploaded_file($profile_tempname, $profile_folder)) {
                echo "Club and images uploaded successfully!";
            } else {
                echo "Failed to upload images.";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Clubs</title>
</head>
<body>
    <form enctype="multipart/form-data" method="post">
        
        <label for="image">Upload Banner Image:</label>
        <input type="file" name="image" required>
        <br><br>

        
        <label for="profileimage">Upload Profile Image:</label>
        <input type="file" name="profileimage" required>
        <br><br>

        <input type="text" name="club_name" placeholder="Club Name" required>
        <br><br>

        <input type="text" name="description" placeholder="Description" required>
        <br><br>

        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>
