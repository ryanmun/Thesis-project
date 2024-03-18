<?php
session_start();

if(isset($_SESSION['user'])) {
    // Directory where images are stored
    $target_dir = "pro-pic/";
    
    // Get the filename of the uploaded file
    $uploaded_filename = $_FILES["fileToUpload"]["name"];
    
    // Extract the file extension
    $imageFileType = pathinfo($uploaded_filename, PATHINFO_EXTENSION);
    
    // Check if the uploaded file has the correct file format (JPG/JPEG)
    if($imageFileType == "jpg" || $imageFileType == "jpeg") {
        // Construct the path to the new image file
        $new_image_path = $target_dir . $_SESSION['user'] . "." . $imageFileType;
        
        // Check if the file was successfully uploaded and move it to the new location
        if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $new_image_path)) {
            // Redirect to the home page
            header('location:home.php');
        } else {
            // Error message if the upload fails
            $msg = "Sorry, there was an error uploading your picture";
            header('location:home.php?msg='.urlencode($msg));
        }
    } else {
        // Error message if the uploaded file format is incorrect
        $msg = "Sorry, only JPG files are allowed";
        header('location:home.php?msg='.urlencode($msg));
    }
} else {
    // Redirect to the login page if the user is not logged in
    header('location:index.php?err='.urlencode('Please Login First To Access this Page !'));
    exit();
}
?>
