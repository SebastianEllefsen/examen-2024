<?php
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

    $sql = "INSERT INTO users (username, password) VALUES ('$input_username', '$input_password')";
    $result = $conn->query($sql);

    if ($result) {
        $message = "User added successfully! Redirecting back to the form in 5 seconds...";
        header("Refresh: 5; URL=reg.php");
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
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md max-w-md w-full">
        <h2 class="text-2xl font-semibold mb-4">Register</h2>
        <form action="" method="post">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-600">Username:</label>
                <input type="text" name="username" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-600">Password:</label>
                <input type="password" name="password" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
            </div>
            <div class="mb-4 text-center text-green-500">
                <?php echo $message; ?>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Register</button>
        </form>
    </div>
</body>
</html>
