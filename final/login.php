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
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute the SQL query to check if the user exists
$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0 ) {
     // Start the session
     session_start();
    
     // Store the username in the session
     $_SESSION['email'] = $email;
 
     header("Location: dashboard.html");
    exit();
     // Redirect to the profile page
     header("Location: profile.php");
    exit();

} else {
    // User not found or incorrect credentials
    echo "Invalid email or password. Please try again.";
}

$conn->close();
?>
