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

        /* Product Card */ 
        .product-card { 
            background-color: #fff; 
            border-radius: 5px; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
            margin: 10px; 
            padding: 20px; 
            width: 200px; /* Fixed width for product card */ 
            text-align: center; 
            transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out; 
        } 

        .product-card:hover { 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
            transform: translateY(-5px); 
        } 

        .product-card h5 { 
            color: #ff9a9e; 
            margin-top: 0; 
            margin-bottom: 10px; 
        } 

        .product-card p { 
            margin-bottom: 10px; 
        } 

        .product-card img { 
            max-width: 100%; 
            height: auto; 
            margin-bottom: 10px; 
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
        <h1>Barter System - Products</h1> 
    </header> 
    <nav> 
        <a href="dashboard.html">Dashboard</a> 
        <a href="my_trades.php">My Trades</a> 
        <a href="../users.php">Messages</a> 
        <a href="setting.html">Settings</a> 
    </nav> 
    <div class="container"> 
        <div class="row"> 
            <?php 
            // Get the top 10 trending products 
            $trending_query = "SELECT p.*, sf.search_count FROM products p JOIN search_frequencies sf ON p.id = sf.id ORDER BY sf.search_count DESC, p.created_at DESC LIMIT 10"; 
            $trending_result = mysqli_query($con, $trending_query); 

            if ($trending_result) { 
                if (mysqli_num_rows($trending_result) > 0) { 
                    ?> 
                    <div class="col-md-12"> 
                        <div class="card mt-4"> 
                            <div class="card-header"> 
                                <h4>Top 10 Trending Products</h4> 
                            </div> 
                            <div class="card-body"> 
                                <div class="row"> 
                                    <?php 
                                    while ($trending_product = mysqli_fetch_assoc($trending_result)) { 
                                        ?> 
                                        <div class="col-md-3"> <!-- Adjusted column size --> 
                                            <div class="product-card mb-4"> <!-- Added margin bottom --> 
                                                <img src="data:image/jpeg;base64,<?= base64_encode($trending_product['image']); ?>" alt="<?= $trending_product['name']; ?>" class="card-img-top"> 
                                                <div class="card-body"> 
                                                    <h5 class="card-title"><?= $trending_product['name']; ?></h5> 
                                                    <p class="card-text"><?= $trending_product['description']; ?></p> 
                                                    <p>Price: <?= $trending_product['price']; ?></p> 
                                                    <a href="products.php?id=<?= $trending_product['id']; ?>" class="button">View Details</a> 
                                                </div> 
                                            </div> 
                                        </div> 
                                        <?php 
                                    } 
                                    ?> 
                                </div> 
                            </div> 
                        </div> 
                    </div> 
                    <?php 
                } 
            } else { 
                echo "Error executing trending products query: " . mysqli_error($con); 
            } 
            ?> 
        </div> 
    </div> 
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script> 
</body> 
</html>
