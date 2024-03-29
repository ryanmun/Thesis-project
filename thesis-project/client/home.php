<style>
    /* Styles for the toast box */
    .toast {
        visibility: hidden;
        min-width: 250px;
        margin: auto;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 5px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        transform: translateX(-50%);
    }

    .toast.show {
        visibility: visible;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    @keyframes fadein {
        from {bottom: 0; opacity: 0;}
        to {bottom: 30px; opacity: 1;}
    }

    @keyframes fadeout {
        from {bottom: 30px; opacity: 1;}
        to {bottom: 0; opacity: 0;}
    }
</style>
<?php
session_start();

if(isset($_SESSION['user']))
	{  echo "<div class = 'textview'>";
	   echo "<h1>Leave Management System</h1>";
	   include 'clientnavi.php';
	   include 'connect.php';
       echo "<h2>Welcome, " . $_SESSION["user"] ."</h2>";
	   if(isset($_GET['msg']))
		{
		$message = $_GET['msg'];
        echo "<div id='toast' class='toast'>$message</div>";
        echo "<script>document.getElementById('toast').classList.add('show');</script>";
   
		echo "<div class = 'error'><b><u>".htmlspecialchars($_GET['msg'])."</u></b></div><br/>";
		}
	   echo "<table>";
		$user = $_SESSION['user'];
		$sql="SELECT * FROM employees WHERE  UserName = '".$user."'";
		$result = $conn->query($sql);
		echo "<table>";
			if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo "<tr><th>Profile Picture : </th><td><img src ='pro-pic/".$user.".jpg' height = 200 width = 200><a href = 'change_pp.php'>Change</a>&nbsp;&nbsp;&nbsp;<a href = 'delete_pp.php'>Delete</a></td></tr>";
						echo "<tr><th>User Name : </th><td>".$row["UserName"]."</tr>";
						echo "<tr><th>Email ID : </th><td>".$row["EmpEmail"]."</td></tr>";
						echo "<tr><th>Employee Name : </th><td>".$row["EmpName"]."</td></tr>";
						echo "<tr><th>Department : </th><td>".$row["Dept"]."</td></tr>";
						echo "<tr><th>Earn Leave : </th><td>".$row["EarnLeave"]."</td></tr>";
						echo "<tr><th>Sick Leave : </th><td>".$row["SickLeave"]."</td></tr>";
						echo "<tr><th>Casual Leave : </th><td>".$row["CasualLeave"]."</td></tr>";
						echo "<tr><th>Date Of Joining : </th><td>".$row["DateOfJoin"]."</td></tr>";
						echo "<tr><th>Current Time : </th><td><div id = 'clock'></div></td></tr>";
						
						}
			}
	   echo "</table>";
	}
else
	{
		header('location:index.php?err='.urlencode('Please Login First For Accessing This Page !'));
		exit();
	}
?>

<html>
<head>
<title>::Leave Management::</title>
<script>
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('clock').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};
    return i;
}
</script>
</head>
<body onload="startTime()">
<link rel='stylesheet' type='text/css' href='style.css'>
<link rel="stylesheet" type="text/css" href="table.css">
