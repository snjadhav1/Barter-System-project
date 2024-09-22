<?php

class UserProfile {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateFullname($email, $newFullname) {
        $query = "UPDATE users SET fullname=? WHERE email=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $newFullname, $email);
        return $stmt->execute();
    }

    public function updateLocation($email, $newLocation) {
        $query = "UPDATE users SET location=? WHERE email=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $newLocation, $email);
        return $stmt->execute();
    }

    public function updateEmail($email, $newEmail) {
        $query = "UPDATE users SET email=? WHERE email=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $newEmail, $email);
        return $stmt->execute();
    }

    public function displayProfile($email) {
        $query = "SELECT * FROM users WHERE email=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<div class='profile-container'>";
            echo "<div class='profile-header'>";
            echo "<img src='logo.png' alt='Logo' class='logo'>";
            echo "<h2>Update Profile</h2>";
            echo "</div>";
            echo "<form method='post' class='profile-form'>";
            echo "<div class='form-group'>";
            echo "<label for='fullname'>Full Name:</label>";
            echo "<input type='text' id='fullname' name='fullname' value='" . $row['fullname'] . "' class='form-control'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='location'>Location:</label>";
            echo "<input type='text' id='location' name='location' value='" . $row['location'] . "' class='form-control'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='new_email'>New Email:</label>";
            echo "<input type='email' id='new_email' name='new_email' class='form-control'>";
            echo "</div>";
            echo "<button type='submit' class='btn btn-primary'>Update Profile</button>";
            echo "</form>";
            echo "</div>";
        } else {
            echo "User not found.";
        }
    }
}

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit;
}

// Example usage:
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "swa1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a user profile instance
$userProfile = new UserProfile($conn);

// Get logged-in user's email from session
$email = $_SESSION['email'];

// Update profile (example)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['fullname'])) {
        $userProfile->updateFullname($email, $_POST['fullname']);
    }
    if (isset($_POST['location'])) {
        $userProfile->updateLocation($email, $_POST['location']);
    }
    if (isset($_POST['new_email'])) {
        $userProfile->updateEmail($email, $_POST['new_email']);
    }
    // Redirect to the login page after update
    header("Location: ../login.php");
    exit;
}

// Display profile
$userProfile->displayProfile($email);

// Close connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            background-image: url('gra.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 100px;
            height: auto;
        }

        .profile-form .form-group {
            margin-bottom: 20px;
        }

        .profile-form .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .profile-form .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .profile-form .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

</body>
</html>