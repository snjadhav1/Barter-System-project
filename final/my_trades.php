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

    // Display products
    $sql = "SELECT id, name, price, image FROM products WHERE user_id = '$user_id' AND status='available'";
    $result = $conn->query($sql);
} else {
    echo "No user found";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Display Products</title>
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
            background-color: #d05155;
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
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        @keyframes slideIn {
            0% {transform: translateX(-100%);}
            100% {transform: translateX(0);}
        }

        /* Product Table */
        table {
            width: 80%; /* Adjusting table width */
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 10px; /* Adding border radius */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adding box shadow */
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .product-card img {
            max-width: 100px;
            height: auto;
            margin-right: 10px;
            vertical-align: middle;
        }

        .product-card h3 {
            margin-top: 0;
        }

        .product-card p {
            margin-bottom: 5px;
        }

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
            margin-top: 20px;
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
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <img src="logo.png" alt="Barter System Logo">
        <h1>Display Products</h1>
    </header>

    <nav>
        <a href="dashboard.html">Dashboard</a>
        <a href="../users.php">messages</a>
        <a href="search_product.php">Search Products</a>
        <a href="setting.html">Settings</a>
        <a href="../logout.php">Logout</a>
        
    </nav>

<main>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="product-card"><img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" alt="Product Image"></td>
                        <td class="product-card">
                            <a href="product_details.php?id=<?php echo $row['id']; ?>"><h3><?php echo $row['name']; ?></h3></a>
                        </td>
                        <td class="product-card">
                            <p>Price: Rs:<?php echo $row['price']; ?></p>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h1>No products found.</h1>
    <?php endif;?>
</main>
<a href="add_product.php" class="button">Add Products</a>
<footer>
    © 2024 Barter System. All rights reserved.
</footer>
</body>
</html>
