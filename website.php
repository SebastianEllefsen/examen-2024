<?php
session_start();

// error reproting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username']) || !isset($_SESSION['session_id'])) {
    // Redirect til velkomst side
    header("Location: login.html");
    exit();
}
// login data
$dbhost = '172.20.128.68:3306';
$dbuser = 'admin1';
$dbpass = 'Troll123!';
$dbname = 'login';
// prøver å logg på server
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$username = $_SESSION['username'];
$session_id = $_SESSION['session_id'];

$sql = "SELECT session_id FROM users WHERE username = '$username'";
$result = $conn->query($sql);
// validering av session og bruker
$valid_session = false;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['session_id'] === $session_id) {
        $valid_session = true;
    } else {
        // Session ID matcher ikke lukk session
        session_unset();
        session_destroy();
        header("Location: login.html");
        exit();
    }
} else {
    // feil bruker lukk session
    session_unset();
    session_destroy();
    header("Location: login.html");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
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
            position: relative;
        }
        .title {
            font-size: 2rem;
            font-weight: 600;
            color: #5d4b85;
            margin-bottom: 1.5rem;
        }
        .message {
            font-size: 1.5rem;
            color: #5d4b85;
        }
        .session-info {
            font-size: 1rem;
            color: #5d4b85;
            margin-top: 1rem;
        }
        .status {
            position: absolute;
            top: 10px;
            right: 10px;
            background: green;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
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
        <h2 class="title">Welcome</h2>
        <p class="message">Welcome, <?php echo htmlspecialchars($username); ?>!</p>
        <p class="session-info">Session ID: <?php echo htmlspecialchars($session_id); ?></p>
        <?php if ($valid_session): ?>
            <div class="status">OK</div>
        <?php endif; ?>
    </div>
    <div class="source">
        <a href="https://www.behance.net/gallery/56730527/Free-Spring-Wallpapers" target="_blank" rel="noopener noreferrer">Image Source</a>
    </div>
</body>
</html>
