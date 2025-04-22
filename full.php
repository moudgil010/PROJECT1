<?php
session_start();
include_once 'db.php';

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = md5($_POST['pass']); 
$cpassword = md5($_POST['cpass']);
$Role = 'user';
$verification_status = '0';

// Checking if fields are empty
if (!empty($fname) && !empty($lname) && !empty($email) && !empty($phone) && !empty($password) && !empty($cpassword)) {
    // Checking if email is valid
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Checking if email already exists
        $sql = mysqli_query($conn, "SELECT email FROM users WHERE email ='{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            echo "$email ~ Already exists";
        } else {
            // Checking if password and confirm password match
            if ($password == $cpassword) {
                // Checking if user uploaded a file
                if (isset($_FILES['image'])) {
                    $img_name = $_FILES['image']['name'];  // Getting image name 
                    $img_typ = $_FILES['image']['type'];   // Getting image type
                    $tmp_name = $_FILES['image']['tmp_name'];
                    $img_explode = explode('.', $img_name);
                    $img_extension = end($img_explode);
                    $extension = ['png', 'jpeg', 'jpg'];  // Valid image extensions

                    if (in_array($img_extension, $extension) === true) {
                        $time = time();
                        $newimagename = $time . $img_name;   // Creating a unique name for image 
                        if (move_uploaded_file($tmp_name, "Images" . $newimagename)) {
                            $random_id = rand(time(), 10000000);  // Creating a user unique id
                            $otp = mt_rand(1111, 9999);   // Creating 4 digit OTP
                            // Inserting data into table
                            $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, phone, password, image, otp, verification_status, Role)
                                  VALUES ('{$random_id}','{$fname}','{$lname}','{$email}','{$phone}','{$password}','{$newimagename}','{$otp}','{$verification_status}','{$Role}')");
                            if ($sql2) {
                                $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if (mysqli_num_rows($sql3) > 0) {
                                    $row = mysqli_fetch_assoc($sql3);    // Fetching data
                                    $_SESSION['unique_id'] = $row['unique_id'];
                                    $_SESSION['email'] = $row['email'];
                                    $_SESSION['otp'] = $row['otp'];

                                    // Start mail function
                                    if($otp){
                                        $receiver = $email;
                                        $subject = "Form: $fname $lname <$email>";
                                        $body = "Name:"." $fname $lname \n Email "." $email \n "." $otp";
                                        $sender = "From: ranan3228@gmail.com";

                                        if (mail($receiver,$subject,$body,$sender)){
                                            echo"success";
                                        }
                                        else{
                                            echo"email problem" . mysqli_error($conn);
                                        }  
                                    }
                                    // End mail function
                                }
                            }
                            else{
                                echo "something went wrong";
                            } 
                        }
                    }
                    else{
                        echo "Please select a Profile Image - JPG, PNG, JPEG";
                    }
                }
                else {
                    echo "Please select a Profile Image";
                }
            }
            else {
                echo "Confirm Password Don't Match";
            }
        } 
    }
    else {
        echo "$email ~ This is not a valid email";
    } 
}
else {
    echo "All input fields are required";
}
?>