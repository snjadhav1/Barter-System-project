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
    $sql = "SELECT id, name, price, status, image FROM products WHERE user_id = '$user_id'";
    $result = $conn->query($sql);
} else {
    echo "No user found";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        header {
            background-color: #d05155;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        img {
            max-width: 100px;
            height: auto;
            vertical-align: middle;
        }

        .status {
            font-weight: bold;
        }

        main {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .button-container {
            text-align: center;
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
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .button:hover {
            background-color: #45a049;
        }

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
        <h1>Product Listing</h1>
    </header>

    <main>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" alt="<?php echo $row['name']; ?>"></td>
                            <td><?php echo $row['name']; ?></td>
                            <td class="status"><?php echo $row['status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </main>

    <div class="button-container">
        <a href="setting.html" class="button">Back</a>
    </div>

    <footer>
        <!-- Footer section remains unchanged -->
    </footer>
</body>
</html>
