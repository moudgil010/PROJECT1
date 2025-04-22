<?php
include_once 'db.php';
session_start();
$otp1 = $_POST['otp1'];
$otp2 = $_POST['otp2'];
$otp3 = $_POST['otp3'];
$otp4 = $_POST['otp4'];
$unique_id = $_SESSION['unique_id'];
$session_otp = $_SESSION['otp'];
$otp = $otp1.$otp2.$otp3.$otp4;

if(!empty($otp)){
    if($otp == $session_otp){
        $stmt = $conn->prepare("SELECT * FROM users WHERE unique_id = ? AND otp = ?");
        $stmt->bind_param("ss", $unique_id, $otp);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0){
            $null_otp = 0;
            $stmt = $conn->prepare("UPDATE users SET verification_status = 'Verified', otp = '0' WHERE unique_id = ?");
            $stmt->bind_param("s", $unique_id);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                $row = $result->fetch_assoc();
                if($row){
                    $_SESSION['unique_id'] = $row['unique_id'];
                    $_SESSION['verification_status'] = $row['verification_status'];
                    echo "success";
                }
            }
        }
    } else {
        echo "Wrong OTP";
    }
} else {
    echo "Enter OTP";
}
?>