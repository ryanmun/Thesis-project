<?php
session_start();

echo "<div class='textview'>";
error_reporting(0);
include 'connect.php';

if (isset($_SESSION['adminuser'])) {
    echo "<h1>Leave Management System</h1>";
    include 'adminnavi.php';
    echo "<h2>Extracted Data</h2>";
    $startdate = strip_tags(trim($_POST['yearstart'])) . "-" . strip_tags(trim($_POST['monthstart'])) . "-" . strip_tags(trim($_POST['datestart']));
    $enddate = strip_tags(trim($_POST['yearend'])) . "-" . strip_tags(trim($_POST['monthend'])) . "-" . strip_tags(trim($_POST['dateend']));
    $sql = "SELECT * FROM emp_leaves WHERE (StartDate >= '" . $startdate . "' AND EndDate <= '" . $enddate . "') OR (EndDate >= '" . $enddate . "' AND StartDate <= '" . $startdate . "') AND Dept = '" . $_SESSION['dept'] . "'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table>
            <tr>
                <th>Employee Name</th>
                <th>Leave Type</th>
                <th>Request Date</th>
                <th>Leave Days</th>
                <th>Status</th>
                <th>Starting Date</th>
                <th>Ending Date</th>
                <th>Department</th>
            </tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row['EmpName']."</td>
                    <td>".$row['LeaveType']."</td>
                    <td>".$row['RequestDate']."</td>
                    <td>".$row['LeaveDays']."</td>
                    <td>".$row['Status']."</td>
                    <td>".$row['StartDate']."</td>
                    <td>".$row['EndDate']."</td>
                    <td>".$row['Dept']."</td>
                </tr>";
        }
        
        echo "</table>";
    } else {
        echo "0 Results !";
    }
} else {
    header('location:index.php?msg=' . urlencode('Please Login First To Access This Page!'));
}

echo "</div>";

?>

<title>::Leave Management::</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="table.css">
