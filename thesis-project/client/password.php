<?php
session_start();
include 'clientnavi.php';
include 'connect.php';

if(isset($_SESSION['user'])) {
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    $cnfnewpass = $_POST['cnfnewpass'];
    $uname = $_SESSION['user'];

    // Validate password confirmation
    if($newpass !== $cnfnewpass) {
        header("location:changepass.php?err=".urlencode('New Passwords Do Not Match!'));
        exit();
    }

    if($newpass !== $oldpass && $newpass !== $uname) {
        if(strlen($newpass) >= 10) {
            // Hash the old password for comparison
            $oldpass_hashed = hash_hmac('sha512', 'salt'.$oldpass, md5($uname));

            $sql = "SELECT id, UserName, EmpPass FROM employees WHERE UserName = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $uname);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = $row['id'];
                $stored_password = $row['EmpPass'];

                // Verify the old password
                if(password_verify($oldpass, $stored_password)) {
                    // Hash the new password
                    $newpass_hashed = password_hash($newpass, PASSWORD_DEFAULT);

                    // Update the password in the database
                    $sql_update = "UPDATE employees SET EmpPass = ? WHERE id = ?";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->bind_param("si", $newpass_hashed, $id);

                    if($stmt_update->execute()) {
                        header("location:home.php?msg=".urlencode('Password Successfully Changed!'));
                        exit();
                    } else {
                        header("location:changepass.php?err=".urlencode('Failed to update password. Please try again later.'));
                        exit();
                    }
                } else {
                    header("location:changepass.php?err=".urlencode('Incorrect Old Password!'));
                    exit();
                }
            } else {
                header("location:changepass.php?err=".urlencode('User not found.'));
                exit();
            }
        } else {
            header('location:changepass.php?err='.urlencode('New Password must be at least 10 characters long!'));
            exit();
        }
    } else {
        header('location:changepass.php?err='.urlencode('New Password cannot be the same as username or old password!'));
        exit();
    }
} else {
    header('location:index.php?err='.urlencode('Please Login First To Access This Page!'));
    exit();
}
?>
