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

// Get the product ID from the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details based on ID
    $sql = "SELECT name, price, description, status, image,user_id FROM products WHERE id = '$product_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $price = $row['price'];
        $description = $row['description'];
        $status = $row['status'];
        $image = $row['image'];
        $user_id=$row['user_id'];

        // Fetch user details based on email (assuming email is unique)
        $email = $_SESSION['email'];
        $user_sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        $user_result = $conn->query($user_sql);

        if ($user_result->num_rows > 0) {
            $user_row = $user_result->fetch_assoc();
            $user_name = $user_row['fullname'];
            $user_email = $user_row['email'];
        } else {
            echo "User details not found.";
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID not provided.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('gra.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

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
            0% { opacity: 0; }
            100% { opacity: 1; }
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

        header img {
            max-height: 50px;
            vertical-align: middle;
        }

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

        main {
            padding: 20px;
            animation: slideIn 1s ease-in-out;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 200px);
        }

        @keyframes slideIn {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(0); }
        }

        .product-details {
            background-color: #f8d7da;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 30px;
            max-width: 100%;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: flex-start;
            transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .product-details:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .product-details h1 {
            color: #721c24;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .product-details h2{
            color: #722007;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .product-details p {
            margin-bottom: 10px;
        }

        .product-details .image-container {
            margin-right: 30px;
        }

        .product-details img {
            max-width: 300px;
            height: auto;
            margin-bottom: 10px;
        }

        .product-details .details-container {
            flex: 1;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin: 0 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .button-red {
            background-color: #d05155;
            color: white;
        }

        .button-green {
            background-color: #4CAF50;
            color: white;
        }

        .button-red:hover {
            background-color: #b24447;
        }

        .button-green:hover {
            background-color: #3e8e41;
        }

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
        <h1>Product Details</h1>
    </header>

    <nav>
        <a href="dashboard.html">Dashboard</a>
        <a href="msg.html">Messages</a>
        <a href="setting.html">Settings</a>
        <a href="logout.php">Logout</a>
        <a href="trial.php">Search Products</a>
    </nav>

    <main>
        <?php if (isset($name)): ?>
            <div class="product-details">
                <div class="image-container">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" width="300">
                </div>
                <div class="details-container">
                    <h1><u><?php echo $name; ?></u></h1>
                    <p>Price: Rs <?php echo $price; ?></p>
                    <p>Description: <?php echo $description; ?></p>
                    <p>Status: <?php echo $status; ?></p>
                    <h2>User Details</h2>
                    <p>Name: <?php echo $user_name; ?></p>
                    <p>Email: <?php echo $user_email; ?></p>
                </div>
            </div>
        <?php else: ?>
            <h1>No product found.</h1>
        <?php endif; ?>
    </main>

    <div class="button-container">
        <?php if (isset($name)): ?>
            <a href="trial.php" class="button button-green">Back to Products</a>
            <?php if ($status == 'Available'): ?>
                
                    
            <?php endif; ?>
            <form action="contact_seller.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <button type="submit" class="button button-red">Contact the Seller</button>
            </form>
        <?php endif; ?>
    </div>

    <footer>
        <!-- Footer section remains unchanged -->
    </footer>
</body>
</html> 