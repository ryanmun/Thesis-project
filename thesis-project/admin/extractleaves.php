<?php
session_start();

echo "<div class = 'textview'>";
error_reporting(0);
require_once ('dompdf_config.inc.php');
include 'connect.php';
if(isset($_SESSION['adminuser']))
	{
	echo "<h1>Leave Management System</h1>";
	include 'adminnavi.php';
	echo "<h2>Extracted Data</h2>";
	$startdate = strip_tags(trim($_POST['yearstart']))."-".strip_tags(trim($_POST['monthstart']))."-".strip_tags(trim($_POST['datestart']));
	$enddate = strip_tags(trim($_POST['yearend']))."-".strip_tags(trim($_POST['monthend']))."-".strip_tags(trim($_POST['dateend']));
	$sql = "SELECT * FROM emp_leaves WHERE (StartDate >= '".$startdate."' AND EndDate <= '".$enddate."') OR (EndDate >= '".$enddate."' AND StartDate <= '".$startdate."') AND Dept = '".$_SESSION['dept']."'";
	$result = $conn->query($sql);
	if($result->num_rows > 0)
		{
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
							";
			$pdf_content = "<h1>Data Extraction For user : ".$_SESSION['adminuser']."</h1>
							<table>
							<tr>
							<th>Employee Name</th>
							<th>Leave Type</th>
							<th>Request Date</th>
							<th>Leave Days</th>
							<th>Status</th>
							<th>Starting Date</th>
							<th>Ending Date</th>
							<th>Department</th>
							";
			while($row = $result->fetch_assoc())
				{
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
					$pdf_content .= "<tr>
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
		$name = $_SESSION['adminuser'].$_SESSION['dept'].strtotime('now').'.pdf';
			$reportPDF = createPDF($pdf_content, $name);
		echo "</table>";
		echo "<a href = 'data-extract/".$name."'>Download The Extracted Data (PDF)</a>";
		}
	else
		{
			echo "0 Results !";
		}
	}
else
	{
	header('location:index.php?msg='.urlencode('Please Login First To Access This Page!'));
	}
function createPDF($pdf_content, $filename){
	
	$path='data-extract/';
	$dompdf=new DOMPDF();
	$dompdf->load_html($pdf_content);
	$dompdf->render();
	$output = $dompdf->output();
	file_put_contents($path.$filename, $output);
	return $filename;		
	}
echo "</div>";
?>
<title>::Leave Management::</title>
<link rel = "stylesheet" href = "style.css">
<link rel = "stylesheet" href = "table.css">