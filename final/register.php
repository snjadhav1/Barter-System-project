<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "swa1"; 

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the submitted form data
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$location = $_POST['location'];
$user_type = $_POST['user_type'];
$gender = $_POST['gender'];

// Validate if password matches confirm password
if ($password !== $confirm_password) {
    echo "Error: Passwords do not match.";
    exit();
}

// Prepare and execute the SQL query to insert the user details
$sql = "INSERT INTO users (fullname, email, password, location, user_type, gender) 
        VALUES ('$fullname', '$email', '$password', '$location', '$user_type', '$gender')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
    header("Location: login.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
