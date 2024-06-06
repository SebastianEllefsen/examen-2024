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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_username = mysqli_real_escape_string($conn, $_POST['username']);
    $input_password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT username, password FROM users WHERE username = '$input_username'";
    $result = $conn->query($sql);

    if (!$result) {
        die('Error in SQL query: ' . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];

        if ($input_password === $stored_password) {
            session_regenerate_id(true);
            $_SESSION['username'] = $input_username; 
            header("Location: website.php");
            exit();
        } else {
            $message = "Invalid username or password. Please try again.";
        }
    } else {
        $message = "Invalid username or password. Please try again.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Additional styles can be placed here */
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center h-screen">
        <form class="bg-white p-10 rounded-lg max-w-sm w-full shadow" method="post" action="">
            <h2 class="text-3xl font-bold mb-8 text-center text-gray-900">Login</h2>
            <div class="mb-4">
                <input type="text" name="username" placeholder="Username"
                       class="w-full p-3 border rounded text-sm mb-3" required>
                <input type="password" name="password" placeholder="Password"
                       class="w-full p-3 border rounded text-sm" required>
            </div>
            <div class="mb-4 text-center text-red-500">
                <?php echo $message; ?>
            </div>
