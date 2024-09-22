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

// Fetch sold out products
$sql = "SELECT * FROM products WHERE status = 'Sold Out'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        body {
            background-image: url('gra.jpg');
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            width: 100px;
            height: 100px;
        }

        .back-btn {
            background-color: #000;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            margin-left: 20px;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Transaction History</h2>

<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Image</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td class='product-card'><img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' alt='Product Image'></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No sold out products found.</td></tr>";
    }
    ?>
    </tbody>
</table>

<a href="setting.html" class="back-btn">Back</a>

</body>
</html>

<?php
$conn->close();
?>
