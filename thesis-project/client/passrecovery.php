<html>
<head>
    <title>::Leave Management::</title>
    <link rel="stylesheet" type="text/css" href="style.css"> <!-- External CSS file -->
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
</head>
<body>
<div class='textview'> <!-- Division for styling -->
    <center>
        <h1>Leave Management System</h1>
        <?php
        include 'navi.php'; // Including navigation
        echo "<h2>Reset Your Password</h2>";
        if(isset($_GET['err'])) {
            echo "<div class='error'><b><u>".htmlspecialchars($_GET['err'])."</u></b></div>"; // Displaying error message if any
        }
        ?>
        <table>
            <tr>
                <td>
                    <button onclick="showToast()">Reset Password</button>
                </td>
            </tr>
        </table>
    </center>
</div>
<div id="toast" class="toast">Please contact your manager for further assistance.</div>
<script>
    function showToast() {
        var toast = document.getElementById("toast");
        toast.className = "toast show";
        setTimeout(function(){
            toast.className = toast.className.replace("show", "");
        }, 3000); // 3 seconds
    }
</script>
</body>
</html>
