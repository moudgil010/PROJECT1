<?php

//if user not login so redirect to login page
session_start();
include 'db.php';
$unique_id = $_SESSION['unique_id'];
$email = $_SESSION['email'];
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
    <title>Animated Emoji</title>
    <style>
        body {
            display: flex;
            justify-content: center; 
            align-items: flex-start; 
            background-color: #615f5f;
            margin: 0;
            padding: 0;
            margin-top: 100px;
        }
        .logout{
            position:fixed;
            margin-top: -70px;
           margin-left: 50%;
           margin-right: -600px;
        }
        .email{
            color: white;
            position: fixed;
            margin-top: -90px;
            margin-left: -440px;
            margin-right: 50%;
            font-size: 18px;
        }
        .emo {
            display: flex;
            justify-content: space-evenly;
            width: 100%;
        }
        .emoji-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .emoji {
            font-size: 100px;
            margin-bottom: 20px; 
            animation: pulse 3s ease-in-out infinite alternate;
        }
        .book-emoji {
            margin-right: 10px; 
        }
        .questionpaper-emoji {
            margin-right: 10px; 
        }
        .buttons {
            display: flex;
            justify-content: space-evenly;
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #15afe2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 10px; /* Adjusted margin */
            margin-right: 10px; /* Adjusted margin */
        }
        button:hover {
            background-color: #eb4d5a;
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.2);
            }
        }
    </style>
</head>
<body>
    <div class="logout">
<header id="header">
    <a href="logout.php?logout_id=<?php echo $unique_id?>"><button class="logout_btn">Log Out</button></a>
</header>
    </div>
    <div class="emo">
        <div class="emoji-container">
            <div class="emoji notes-emoji">📝</div>
            <button onclick="uploadNotes()">Upload Notes</button>
        </div>
        <div class="emoji-container">
            <div class="emoji book-emoji">📗</div>
            <button onclick="uploadBooks()">Upload Books</button>
        </div>
        <div class="emoji-container">
            <div class="emoji questionpaper-emoji">📃</div>
            <button onclick="uploadQuestionPaper()">Upload Question Paper</button>
        </div>
    </div>
    <script>
        function uploadNotes() {
    // Redirect to index.php with email as query parameter
    window.location.href = "index.php?email=<?php echo urlencode($email); ?>";
}
        function uploadBooks() {
            // Add your logic for uploading books here
            window.location.href = "book.php?email=<?php echo urlencode($email); ?>";
        }
        function uploadQuestionPaper() {
            // Add your logic for uploading question paper here
            window.location.href = "questionpaper.php?email=<?php echo urlencode($email); ?>";
        }
    </script>
    <div class="email">
    <section>
    <h4> Welcome: <span><?php echo $email; ?> </span></h4>
</section>
    </div>
</body>
</html>
