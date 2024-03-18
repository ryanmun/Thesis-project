<link rel="shortcut icon" type="image/png" href="favicon.png"/>
<?php
session_start();
?>

<html>
<head>
<title>::Leave Management::</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
<div class="textview">
<?php
echo "<h1>Leave Management System</h1>";
include 'adminnavi.php';
include 'connect.php';

if(filter_var($_GET['id'], FILTER_VALIDATE_INT) && filter_var($_GET['empid'], FILTER_VALIDATE_INT)) {
    $id = $_GET['id'];
    $empid = $_GET['empid'];
} else {
    header('location:home.php');
}

if(isset($_SESSION['adminuser'])) {
    $sql = "SELECT * FROM emp_leaves WHERE id='".$id."'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $sql2 = "SELECT id,EmpEmail FROM employees WHERE id = '".$empid."'";
            $result2 = $conn->query($sql2);
            if($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    $email = $row2['EmpEmail'];
                    $sql3 = "UPDATE emp_leaves SET Status = 'Rejected' WHERE id = '".$id."'";
                    if($conn->query($sql3) === TRUE) {
                        // Removed the mailer code
                        echo "The Leave Request Status Mail For ".$row['EmpName']." Has been sent to his/her registered email address !<br/>";
                        // Redirect to view_leaves.php after the decision is made
                        header("Location: view_leaves.php");
                        exit(); // Make sure to exit after the header redirection
                    }	
                }
            }
        }
    }
} else {
    header('location:index.php?err='.urlencode('Please Login First To Access This Page !'));
}
?>
</div>
</body>
</html>
