<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbhost = '172.20.128.68:3306';
$dbuser = 'admin1';
$dbpass = 'Troll123!';
$dbname = 'login';

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = mysqli_real_escape_string($conn, $_POST['username']);
    $input_password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($input_password, PASSWORD_DEFAULT); // Hash the password
    $session_id = session_id(); 

    $sql = "INSERT INTO users (username, password, session_id) VALUES ('$input_username', '$hashed_password', '$session_id')";
    $result = $conn->query($sql);

    if ($result) {
        $_SESSION['username'] = $input_username; 
        $_SESSION['session_id'] = $session_id; 
        header("Location: welcome.php"); 
        exit();
    } else {
        $message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            background: url('https://mir-s3-cdn-cf.behance.net/project_modules/fs/6aed5e56730527.59ba033156f54.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .title {
            font-size: 2rem;
            font-weight: 600;
            color: #5d4b85;
            margin-bottom: 1.5rem;
        }
        .input-field {
            border: 2px solid #e0d6b8;
            padding: 0.75rem;
            border-radius: 5px;
            width: 100%;
            margin-bottom: 1rem;
            font-family: 'Poppins', sans-serif;
        }
        .custom-button {
            background: #7e22ce;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 5px;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .custom-button:hover {
            background: #b084cc;
            transform: scale(1.05);
        }
        .link {
            color: #7e22ce;
            display: block;
            margin-top: 1rem;
            text-decoration: none;
            font-weight: 600;
        }
        .link:hover {
            text-decoration: underline;
        }
        .message {
            color: #5d4b85;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .source {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.8);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="title">Register</h2>
        <form action="reg.php" method="post">
            <input type="text" name="username" placeholder="Username" class="input-field" required>
            <input type="password" name="password" placeholder="Password" class="input-field" required>
            <div class="message"><?php echo $message; ?></div>
            <button type="submit" class="custom-button">Register</button>
        </form>
        <a href="login.html" class="link">Login</a>
    </div>
    <div class="source">
        <a href="https://www.behance.net/gallery/56730527/Free-Spring-Wallpapers" target="_blank" rel="noopener noreferrer">Image Source</a>
    </div>
</body>
</html>
