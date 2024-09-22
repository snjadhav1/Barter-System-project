<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the product ID is provided
if (isset($_POST['product_id'])) {
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "swa1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the product ID from the form
    $product_id = $_POST['product_id'];

    // Update product status to "Sold Out"
    $update_sql = "UPDATE products SET status = 'Sold Out' WHERE id = '$product_id'";
    if ($conn->query($update_sql) === TRUE) {
        // Delete the product from the database
       
            header("Location: my_trades.php");
            exit();
    
    } else {
        echo "Error updating product status: " . $conn->error;
    }

    $conn->close();
} else {
    // Redirect to the product details page if product ID is not provided
    header("Location: product_details.php");
    exit();
}
?>
