<?php
// Retrieve email from query parameter
$email = isset($_GET['email']) ? $_GET['email'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Upload Notes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #3a3e3f;
        }
        .email{
            color: white;
            position: fixed;
            margin-top: -50px;
            margin-left: 20px;
            font-size: 20px;
        }
        #header {
            background-color: #007bff;
            padding: 15px;
            text-align: right;
        }
        .logout_btn {
            padding: 8px 16px;
            font-size: 16px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .logout_btn:hover {
            background-color: #c82333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #007bff;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<header id="header">
    <?php 
        // Catching email passed from previous page
        if(!empty($email)) {
            // Escape output to prevent XSS
            $email = htmlspecialchars($email);
            echo '<a href="logout.php?logout_id='.$email.'"><button class="logout_btn">Log Out</button></a>';
        } else {
            echo '<a href="logout.php"><button class="logout_btn">Log Out</button></a>';
        }
    ?>
</header>
<div class="email">
<?php 
        // Print the email
        echo '<p> ' . $email . '</p>';
    ?>
</div>
<div class="container mt-5">
    <h2>Upload Books</h2>
    <form action="uploadbooks.php" method="POST" enctype="multipart/form-data">
        <!-- Hidden input field to pass email to upload.php -->
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <div class="mb-3">
            <label for="file" class="form-label">Select file</label>
            <input type="file" class="form-control" name="file" id="file">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
</body>
</html>
