<?php
// Start the session
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "swa1");

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch user unique_id
$email = $_SESSION['email'];
$sql = "SELECT unique_id FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $unique_id = $row['unique_id'];

    // Retrieve notifications for the logged-in user (including messages)
    $notification_query = "
        SELECT 
            CONCAT(u.fullname, ' sent you a message: ', n.content) AS message, 
            n.when 
        FROM notifications n 
        JOIN users u ON n.by_user = u.unique_id 
        WHERE n.user_id = '$unique_id'
        ORDER BY n.when DESC 
        LIMIT 5
    ";

    // Run the notification query
    $notification_result = mysqli_query($conn, $notification_query);

    // Check for errors in the notification query
    if (!$notification_result) {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Error: User not found";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        header {
            background-color: #d05155;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        nav {
            display: none; /* Hide the navigation */
        }

        main {
            padding: 20px;
            text-align: center;
        }

        section {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }

        h2, h3 {
            color: #d05155;
        }

        ul {
            list-style-type: none;
            padding: 0;
            text-align: left;
        }

        li {
            margin-bottom: 10px;
        }

        .message-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .back-button {
            background-color: black;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: block;
            border-radius: 5px;
            position: fixed;
            bottom: 20px;
            left: 20px;
        }

        header img {
            width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
<header>
    <img src="logo.png" alt="Logo">
    <h1>Notifications</h1>
</header>

<main>
    <section>
        <h2>Messages:</h2>
        <ul>
            <?php 
            // Check if there are any notifications
            if (mysqli_num_rows($notification_result) > 0) {
                while ($row = mysqli_fetch_assoc($notification_result)) : 
            ?>
                <li><?= $row['message'] ?> - <?= $row['when'] ?></li>
            <?php 
                endwhile;
            } else {
                echo "<li>No messages found.</li>";
            }
            ?>
        </ul>
        <a href="../users.php" class="message-button">Message Section</a>
    </section>
</main>

<script>
    // JavaScript code
</script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
