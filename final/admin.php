<?php
// Start the session
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if not logged in or user is not an admin
    header("Location: login.php");
    exit();
}

// Database connection details
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_query = $_POST["search_query"];

    // Query to fetch user data and their associated products based on the search query
    $sql = "SELECT users.user_id, users.fullname, users.email, users.location, users.user_type, users.gender, products.id AS product_id, products.name AS product_name, products.price, products.description, products.status, products.image 
            FROM users 
            LEFT JOIN products ON users.user_id = products.user_id 
            WHERE users.fullname LIKE '%$search_query%' 
            OR users.email LIKE '%$search_query%' 
            OR users.location LIKE '%$search_query%' 
            OR users.user_type LIKE '%$search_query%' 
            OR users.gender = '$search_query'
            OR products.name LIKE '%$search_query%' 
            OR products.price LIKE '%$search_query%' 
            OR products.description LIKE '%$search_query%' 
            OR products.status LIKE '%$search_query%'";
    $result = $conn->query($sql);
}

// Handle delete request
if(isset($_GET['delete_user_id'])) {
    $delete_user_id = $_GET['delete_user_id'];
    if(isset($_GET['delete_products'])) {
        // Delete selected products associated with the user
        if(isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
            $sql_delete_product = "DELETE FROM products WHERE user_id = '$delete_user_id' AND id = '$product_id'";
            if($conn->query($sql_delete_product) === TRUE) {
                echo "Product deleted successfully.<br>";
            } else {
                echo "Error deleting product: " . $conn->error . "<br>";
            }
        } else {
            echo "No product selected for deletion.<br>";
        }
    } else {
        // Then, delete the user
        $sql_delete_user = "DELETE FROM users WHERE user_id = '$delete_user_id'";
        if($conn->query($sql_delete_user) === TRUE) {
            echo "User deleted successfully.<br>";
        } else {
            echo "Error deleting user: " . $conn->error . "<br>";
        }
    }
    
    // Redirect back to the same page to avoid displaying outdated data
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barter System - Admin</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        header img {
            max-height: 50px;
            vertical-align: middle;
        }
        main {
            padding: 20px;
        }
        section {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        td img {
            max-width: 100px;
            max-height: 100px; /* Set max-height */
            height: auto; /* Ensure aspect ratio is maintained */
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            padding: 8px;
            width: 200px;
        }
        .delete-btn {
            padding: 8px 20px;
            background-color: #f44336; /* Red */
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
        }
        .delete-btn:hover {
            background-color: #d32f2f; /* Darker Red */
        }
        .logout-btn {
            padding: 8px 20px;
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            float: right;
        }
        .logout-btn:hover {
            background-color: #45a049; /* Darker Green */
        }
    </style>
</head>
<body>
    <header>
        <img src="logo.png" alt="Barter System Logo">
        <h1>Barter System - Admin</h1>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </header>

    <main>
        <section>
            <h2>Search Users and Products</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="search_query">Search:</label>
                <input type="text" id="search_query" name="search_query" required>
                <button type="submit">Search</button>
            </form>
        </section>

        <section>
            <h2>User and Product Results</h2>
            <?php
            if (isset($result) && $result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>User Full Name</th><th>User Email</th><th>User Location</th><th>User Type</th><th>User Gender</th><th>Product Name</th><th>Product Price</th><th>Product Description</th><th>Product Status</th><th>Product Image</th><th>Action</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["fullname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["location"] . "</td>";
                    echo "<td>" . $row["user_type"] . "</td>";
                    echo "<td>" . $row["gender"] . "</td>";
                    echo "<td>" . $row["product_name"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' alt='Product Image' style='max-width: 100px; max-height: 100px;'></td>";
                    echo "<td>";
                    echo "<a class='delete-btn' href='?delete_user_id=" . $row['user_id'] . "&delete_products=1&product_id=" . $row['product_id'] . "'>Delete Product</a> / ";
                    echo "<a class='delete-btn' href='?delete_user_id=" . $row['user_id'] . "'>Delete User</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No user or product data found.";
            }
            ?>
        </section>
    </main>

    <footer>
        &copy; Barter System
    </footer>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
