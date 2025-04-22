<?php

//if user not login so redirect to login page
session_start();
include 'db.php';
$unique_id = $_SESSION['unique_id'];
if(empty($unique_id)){
    header("Location: login.php");
}
$qry = mysqli_query($conn , "SELECT * FROM users WHERE unique_id ='{$unique_id}'");
if(mysqli_num_rows($qry) > 0){
    $row = mysqli_fetch_assoc($qry);
    if($row){
        $_SESSION['verification_status'] = $row['verification_status'];
        if($row['verification_status'] != 'Verified'){
            header("Location: verify.php");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP Page</title>
</head>
<body>
    <h1>Hello, World!</h1>
    <p>This is a simple PHP page.</p>
    <?php
        // PHP code can be embedded within HTML
        $name = "John";
        echo "<p>Welcome, $name!</p>"; // This will display "Welcome, John!"
    ?>
</body>
</html>
