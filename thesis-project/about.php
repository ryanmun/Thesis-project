<!DOCTYPE html>
<html>
<head>
<title>::Leave Management::</title>
<style> 
body{
  background-image:url("background2.jpeg");
  background-size: cover;
  background-color: rgba(255,255,255,0.5);
}

.title {
    text-align: center;
    margin-top: 0; 
    padding-top: 20px; 
}
</style>
</head>
<body>
<?php
echo "<div class='heading'>";
echo "<h1 class='title'>Leave Management System</h1>";
include 'navi.php';
echo "<center>";

echo "<h4>The project has the following components: </h4>";
echo "<p>CLIENT CONSOLE </p>";
echo "<p>ADMIN MANAGEMENT CONSOLE</p>";
echo "<p>CLIENT REGISTRATION COMPONENT</p>";
echo "<p>Before accessing the CLIENT CONSOLE, the client has to be registered by the admin in the ADMIN MANAGEMENT CONSOLE. The
registration component consists of a simple HTML form and the
confirmation page for the same.</p>";

echo "<h4>The CLIENT CONSOLE consists of the following features:</h4>"; 

echo "<p>Requesting for a leave</p>"; 
echo"<p> Password recovery option (through email) </p>";
echo "<p>Seeing the number of leaves available to him/her and all the details
about him/her </p>"; 
echo "<p>Viewing the complete profile of him/her with his/her
profile picture along with the all the types of leaves (Casual, Sick
and Earn) sanctioned to him/her by the admin</p>";
 
echo "<h4>The ADMIN MANAGEMENT CONSOLE consists of the following features:</h4>";
 echo"<p> Removal of an employee (if he/she has quit the company)</p>"; 
 echo "<p> Power of granting/rejecting the leaves requested by the client with/without specifying the reason.
Also, searching and deleting the employee as per his/her department associated with</p>"; 
echo "<p> Seeing the type of leaves sanctioned by him/her to the client</p>";
echo "</center>";
echo "</div>";

?>

</body>
</html>
