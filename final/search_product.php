<?php
// Start the session at the very beginning of your PHP code
session_start();

$con = mysqli_connect("localhost", "root", "", "swa1");

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Funda Of Web IT</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            0% {transform: scale(1);}
            50% {transform: scale(1.2);}
            100% {transform: scale(1);}
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
        /* Profile Section */
        #profile-section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
        }
        #profile-section:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }
        #profile-section h2 {
            color: #ff9a9e;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        #profile-section .profile-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 20px;
        }
        #profile-section .profile-info div {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
        }
        #profile-section .profile-info div:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        #profile-section .profile-info div h3 {
            color: #ff9a9e;
            margin-top: 0;
        }
        #profile-section .profile-info div p {
            margin-bottom: 5px;
        }
        /* Footer */
        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        /* Adjustments */
        .product-image {
            width: 100px; /* Fixed width for image */
            height: 100px; /* Fixed height for image */
            object-fit: cover; /* Maintain aspect ratio */
        }
    </style>
</head>
<body>

<header>
    <img src="logo.png" alt="Barter System Logo">
    <h1>Barter System - Products_Search</h1>
</header>

<nav>
    <a href="dashboard.html">Dashboard</a>
    <a href="my_trades.php">My Trades</a>
    <a href="setting.html">Settings</a>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>PRODUCTS SEARCH BAR </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <form action="" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search data">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th> <!-- Added Image column -->
                                <th>Name</th>
                                <th>Description</th> <!-- Added Description column -->
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        if (isset($_GET['search'])) {
    $filtervalues = $_GET['search'];
    $user_email = $_SESSION['email']; // Get the user's email from session

    // Get the user_id based on the email
    $query_user_id = "SELECT user_id FROM users WHERE email = '$user_email'";
    $result_user_id = mysqli_query($con, $query_user_id);
    if ($result_user_id) {
        $user_row = mysqli_fetch_assoc($result_user_id);
        $current_user_id = $user_row['user_id'];

        // Updated query to exclude products added by the current user
        $query = "SELECT * FROM products WHERE name LIKE '%$filtervalues%' AND user_id != $current_user_id AND status='available'";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                foreach ($query_run as $items) {
                    $product_id = $items['id'];

                    // Check if the product_id exists in the search_frequencies table
                    $check_query = "SELECT * FROM search_frequencies WHERE id = $product_id";
                    $check_result = mysqli_query($con, $check_query);

                    if ($check_result) {
                        if (mysqli_num_rows($check_result) > 0) {
                            // Update the search_count for the existing product_id
                            $update_query = "UPDATE search_frequencies SET search_count = search_count + 1 WHERE id = $product_id";
                            mysqli_query($con, $update_query);
                        } else {
                            // Insert a new row for the product_id
                            $insert_query = "INSERT INTO search_frequencies (id, search_count) VALUES ($product_id, 1)";
                            mysqli_query($con, $insert_query);
                        }
                    } else {
                        echo "Error executing check query: " . mysqli_error($con);
                    }

                    // Your existing code for displaying search results
                    ?>
                    <tr>
                        <td><?= $items['id']; ?></td>
                        <td>
                            <a href="products.php?id=<?= $items['id']; ?>">
                                <img src="data:image/jpeg;base64,<?= base64_encode($items['image']); ?>" alt="<?= $items['name']; ?>" class="product-image">
                            </a>
                        </td>
                        <td><a href="products.php?id=<?= $items['id']; ?>"><?= $items['name']; ?></a></td>
                        <td><?= $items['description']; ?></td> <!-- Display Description -->
                        <td><?= $items['price']; ?></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">No Record Found</td>
                </tr>
                <?php
            }
        } else {
            echo "Error executing main query: " . mysqli_error($con);
        }
    } else {
        echo "Error executing user ID query: " . mysqli_error($con);
    }
}
       ?>                 </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>  
