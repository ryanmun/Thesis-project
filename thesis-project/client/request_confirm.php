<html>
<head>
<title>::Leave Request Confirmation::</title>
<style>
        /* Additional styling for the toast message */
        .toast {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
        }
        .toast.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }
        @-webkit-keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }
        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }
        @-webkit-keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }
        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }
    </style>
<?php
session_start();
include 'connect.php';
include 'clientnavi.php';

$user = $_SESSION['user'];
echo "<link rel='stylesheet' type='text/css' href='style.css'>";
echo "<div class = 'textview'>";
echo "<center>";
if(isset($user))
	{
	$leavetype = $_POST['leavetype'];
	$leavedays = $_POST['leavedays'];
	$leavedate = $_POST['leaveyear']."-".$_POST['leavemonth']."-".$_POST['leavedate'];
	$date = date_create($leavedate);
	$duration = $leavedays." days";
	$interval = date_interval_create_from_date_string($duration);
	$enddate = date_add($date,$interval);
	$end = date_format($enddate,"Y-m-d");
	$empname = $_POST['empname'];
	$emptype = $_POST['emptype'];
	$designation = $_POST['designation'];
	$emptype = $_POST['emptype'];
	$empfee = $_POST['empfee'];
	$leavereason = $_POST['leavereason'];
	$dept = $_POST['dept'];
		if(!empty($leavedays))

			{
				if(strtotime($leavedate) > time())
				{
				$sql = "SELECT * FROM employees WHERE UserName='".$user."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						if($row["UserName"] == $user)
							{
								if($leavetype === "Sick Leave")
								{
									if(($leavedays <= $row["SickLeave"]) || $leavedays < 0)
										{
										$empname = $row["EmpName"];
										$to = $row["EmpEmail"];
										$sql2 = "INSERT INTO emp_leaves(EmpName,LeaveType,LeaveDays,StartDate,EndDate,Dept) VALUES('".$empname."','".$leavetype."','".$leavedays."','".$leavedate."','".$end."','".$row['Dept']."')";
											if (mysqli_query($conn, $sql2))
											{
											
											header("Location: my_leaves.php");}
											else
											{
											echo "Error: " . $sql . "<br>" . mysqli_error($conn);
											}
										}
									else
									{
									header('location:request_leave.php?err='.urlencode("You cannot ask for sick leaves more than that of your account !"));
									}
								}
								if($leavetype === "Earn Leave")
								{
									if(($leavedays <= $row["EarnLeave"]) || $leavedays < 0)
										{
										$empname = $row["EmpName"];
										$to = $row["EmpEmail"];
										$sql2 = "INSERT INTO emp_leaves(EmpName,LeaveType,LeaveDays,StartDate,EndDate,Dept) VALUES('".$empname."','".$leavetype."','".$leavedays."','".$leavedate."','".$end."','".$row['Dept']."')";;
											if (mysqli_query($conn, $sql2))
											{
												header("Location: my_leaves.php");}
											else
											{
										
											echo "Error: " . $sql . "<br>" . mysqli_error($conn);
											}
										}
									else
									{
									header('location:request_leave.php?err='.urlencode("You cannot ask for earn leaves more than that of your account !"));
									}
								}
								if($leavetype === "Casual Leave")
								{
									if(($leavedays <= $row["CasualLeave"]) || $leavedays < 0)
										{
										$empname = $row["EmpName"];
										$to = $row["EmpEmail"];
										$sql2 = "INSERT INTO emp_leaves(EmpName,LeaveType,LeaveDays,StartDate,EndDate,Dept) VALUES('".$empname."','".$leavetype."','".$leavedays."','".$leavedate."','".$end."','".$row['Dept']."')";
											if (mysqli_query($conn, $sql2))
											{
											
											header("Location: my_leaves.php");
										}
											else
											{
											echo "Error: " . $sql . "<br>" . mysqli_error($conn);
											}
										}
									else
									{
									header('location:request_leave.php?err='.urlencode("You cannot ask for casual leaves more than that of your account !"));
									}
								}
							}
						}
					}
error_reporting(0);}
				else
					{
					header('location:request_leave.php?err='.urlencode('Start Date is invalid !'));
					}
			}
		
		else
			{
			header('location:request_leave.php?err='.urlencode('Pl. Enter some details !'));
			}
	}
	else
	{
	header('location:index.php?err='.urlencode('Please Login first to access this page'));
	}
echo "</center>";
echo "</div>";
$conn->close();
function createPDF($pdf_content, $filename){
	
	$path='leaves/';
	$dompdf=new DOMPDF();
	$dompdf->load_html($pdf_content);
	$dompdf->render();
	$output = $dompdf->output();
	file_put_contents($path.$filename, $output);
	return $filename;		
	}
?>

<script type="text/javascript">
        function noBack()
         {
             window.history.forward()
         }
        noBack();
        window.onload = noBack;
        window.onpageshow = function(evt) { if (evt.persisted) noBack() }
        window.onunload = function() { void (0) }
    </script>
</head>
</html>