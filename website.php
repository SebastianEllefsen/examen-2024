<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];
$session_id = session_id();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md max-w-md w-full text-center">
        <h2 class="text-2xl font-semibold mb-4">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <p class="text-gray-600">You have successfully logged in.</p>
        <p class="text-gray-600">Session ID: <?php echo htmlspecialchars($session_id); ?></p>
    </div>
</body>
</html>
