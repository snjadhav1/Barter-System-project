<?php
// Start the session
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "swa1");

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Fetch user ID
$email = $_SESSION['email'];
$sql = "SELECT user_id FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];
}

// Log user login activity
$activity_description = "Logged in";
$log_query = "INSERT INTO user_activity (user_id, activity, timestamp) VALUES ('$user_id', '$activity_description', NOW())";
mysqli_query($conn, $log_query);

// Update existing log entries
$update_query = "UPDATE user_activity SET activity = 'Logged in' WHERE activity = 'Performed some activity'";
mysqli_query($conn, $update_query);

// Retrieve recent activity for the logged-in user
$activity_query = "SELECT activity, timestamp FROM user_activity WHERE user_id = $user_id ORDER BY timestamp DESC LIMIT 5";
$activity_result = mysqli_query($conn, $activity_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barter System Recent Activity</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('gr.webp'); /* Background Image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Header */
        header {
            background-color: rgba(0, 0, 0, 0.3); /* Semi-transparent background */
            color: #fff;
            padding: 20px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
            position: relative;
            overflow: hidden;
        }

        @keyframes fadeIn {
            0% {opacity: 0;}
            100% {opacity: 1;}
        }

        header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #ff9a9e, #fad0c4);
            animation: pulse 5s infinite;
            opacity: 0.5;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Logo */
        header img {
            max-height: 50px;
            vertical-align: middle;
            filter: brightness(0.5); /* Darken the logo */
        }

        /* Barter System Dashboard name */
        header h1 {
            color: rgba(255, 255, 255, 0.9); /* Light color for visibility */
            margin-top: 5px; /* Adjusting the margin */
        }

        /* Navigation */
        nav {
            background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent background */
            padding: 10px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        nav a {
            color: #333;
            text-decoration: none;
            padding: 10px;
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
            position: relative;
        }

        nav a::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #ff9a9e;
            transform: scaleX(0);
            transition: transform 0.3s ease-in-out;
        }

        nav a:hover {
            background-color: #ddd;
            color: #ff9a9e;
        }

        nav a:hover::before {
            transform: scaleX(1);
        }

        /* Main Content */
        main {
            padding: 20px;
            animation: slideIn 1s ease-in-out;
        }

        @keyframes slideIn {
            0% {transform: translateX(-100%);}
            100% {transform: translateX(0);}
        }

        /* Sections */
        section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent background */
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        section:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        section h2 {
            color: #ff9a9e;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Footer */
        footer {
            background-color: rgba(0, 0, 0, 0.8); /* Semi-transparent background */
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        /* Custom Animation */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Additional Styling */
        main section:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.5); /* Semi-transparent background for alternate sections */
        }

        main section p {
            margin-bottom: 10px;
        }

    </style>
</head>
<body>
<header>
    <img src="logo.png" alt="Barter System Logo">
    <h1>Barter System -Recent Activity by the User</h1>
</header>

<nav>
    <a href="profile.php">Profile</a>
    <a href="my_trades.php">My Trades</a>
    <a href="../users.php">Messages</a>
    <a href="search_product.php">Search Products</a>
    <a href="setting.html">Settings</a>
    
</nav>

<main>
    <section style="animation: fadeInUp 1s ease-in-out;"> <!-- Animated section -->
        <h2>Here's a quick overview of your recent activity:</h2>
        <ul>
            <?php
            while ($row = mysqli_fetch_assoc($activity_result)) {
                echo "<li>{$row['activity']} - {$row['timestamp']}</li>";
            }
            ?>
        </ul>
        <a href="javascript:history.back()">Back</a>
    </section>
</main>

<footer>
    &copy; Barter System
</footer>

<script>
    // Add any necessary JavaScript code here
</script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
