<link rel="shortcut icon" type="image/png" href="favicon.png"/>
<?php
session_start();

include 'connect.php';
if(isset($_SESSION['adminuser']))
	{
	$setsickleave = strip_tags(trim($_POST['setsickleave']));
	$setearnleave = strip_tags(trim($_POST['setearnleave'])); 
	$setcasualleave = strip_tags(trim($_POST['setcasualleave']));
	
	$sql2 = "SELECT Dept,username,SetEarnLeave,SetCasualLeave,SetSickLeave FROM admins WHERE username = '".$_SESSION['adminuser']."'";
	$result = $conn->query($sql2);
	if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
				{
					$sql3 = "SELECT Dept,SickLeave,EarnLeave,CasualLeave FROM employees WHERE Dept = '".$row["Dept"]."'";
					$result2 = $conn->query($sql3);
					if($result2->num_rows > 0)
						{
							while($row2 = $result2->fetch_assoc())
								{
									if($row2["EarnLeave"] == $row["SetEarnLeave"])
										{
											$update = "UPDATE employees SET EarnLeave = '".$setearnleave."' WHERE Dept = '".$row2["Dept"]."'";
											$conn->query($update);
										}
									if($row2["SickLeave"] == $row["SetSickLeave"])
										{
											$update = "UPDATE employees SET SickLeave = '".$setsickleave."'WHERE Dept = '".$row2["Dept"]."'";
											$conn->query($update);
										}
									if($row2["CasualLeave"] == $row["SetCasualLeave"])
										{
											$update = "UPDATE employees SET CasualLeave = '".$setcasualleave."' WHERE Dept = '".$row2["Dept"]."'";
											$conn->query($update);
										}
								}
						}
				}
		}
	
	$sql = "UPDATE admins SET SetSickLeave = '".$setsickleave."', SetEarnLeave = '".$setearnleave."', SetCasualLeave = '".$setcasualleave."' WHERE username = '".$_SESSION['adminuser']."'";
	if($conn->query($sql) == TRUE)
		{
		header('location:set_leaves.php?msg='.urlencode('Leaves Were Set Succesfully!'));
		}
	else
		{
		header('location:set_leaves.php?msg='.urlencode('Setting Of Leaves Failed!'));
		}
	}
else
	{
	header('location:index.php?err='.urlencode('Please Login First To Access This Page!'));
	}
?>