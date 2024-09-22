<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

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

// Fetch user details based on email from session
$email = $_SESSION['email'];
$sql = "SELECT user_id FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];

    // Add product
    
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    
        $sql = "INSERT INTO products (name, price, description, status, image, user_id) 
                VALUES ('$name', '$price', '$description', '$status', '$image', '$user_id')";
    
        if ($conn->query($sql) === TRUE) {
            echo "Product added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    }
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
    
    <style>
           /* Global Styles */
           body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('gra.jpg'); /* Background Image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: rgba(0, 0, 0, 0.5); /* Transparent background color */
        }

        /* Header */
        header {
            background-color: #333;
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
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        /* Logo */
        header img {
            max-height: 50px;
            vertical-align: middle;
        }

        /* Navigation */
        nav {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        /* Form */
        form {
            margin-bottom: 30px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.5); /* Semi-transparent white background */
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        form:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        form h2 {
            color: #ff9a9e;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="number"],
        form textarea,
        form select,
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
            background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent white background */
            color: #333; /* Text color */
        }

        form input[type="submit"] {
            background-color: #ff9a9e;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        form input[type="submit"]:hover {
            background-color: #ff9a9e;
        }

        /* Button styling */
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #d05155; /* Green background color */
            color: white; /* White text color */
            text-decoration: none; /* Remove underline */
            border: none; /* Remove border */
            border-radius: 5px; /* Rounded corners */
            font-size: 16px; /* Font size */
            cursor: pointer; /* Cursor style */
        }

        /* Hover effect */
        .button:hover {
            background-color: #d05155; /* Darker green on hover */
        }

        /* Footer */
        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <img src="logo.png" alt="Barter System Logo">
        <h1>Add Product</h1>
    </header>

    <nav>
        <a href="dashboard.html">Dashboard</a>
        <a href="setting.html">Settings</a>
       
    </nav>

    <main>
        <form method="post" enctype="multipart/form-data">
            <h2>Add Product</h2>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br><br>

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01" required><br><br>
           
            <label for="description">Description:</label>
    <textarea name="description" id="description" rows="4" required></textarea><br><br>

    <label for="status">Status:</label>
    <select name="status" id="status" required>
        <option value="Available">Available</option>
       
    </select><br><br>

            <label for="image">Image:</label>
            <input type="file" name="image" id="image" required><br><br>

            <input type="submit" name="submit" value="Add Product">
        </form>
        <a href="my_trades.php" class="button">View Products</a>
    </main>

    <footer>
        &copy; 2024 Barter System. All rights reserved.
    </footer>
</body>
</html>