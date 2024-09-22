<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the username from the session
$email = $_SESSION['email'];

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

// Query to fetch user data from the database
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

// Check if the query returned any rows
if ($result->num_rows > 0) {
    // Fetch user data as an associative array
    $user_data = $result->fetch_assoc();

    // Extract relevant user data
    $fullname = $user_data['fullname'];
    $email = $user_data['email'];
    $location = $user_data['location'];
    $user_type = $user_data['user_type'];
    $gender = $user_data['gender'];
    $user_id = $user_data['user_id'];
  
} else {
    echo "No user data found.";
}

// Query to fetch total trades count from the database
$sql_total_trades = "SELECT COUNT(*) AS total_trades FROM products WHERE user_id = '$user_id'";
$result_total_trades = $conn->query($sql_total_trades);

// Fetch total trades count as an associative array
if ($result_total_trades->num_rows > 0) {
    $total_trades_data = $result_total_trades->fetch_assoc();
    $total_trades = $total_trades_data['total_trades'];
} else {
    $total_trades = 0; // Default value if no trades found
}

// Query to fetch successful trades count from the database
$sql_successful_trades = "SELECT COUNT(*) AS successful_trades FROM products WHERE user_id = '$user_id' AND status = 'Sold Out'";
$result_successful_trades = $conn->query($sql_successful_trades);

// Fetch successful trades count as an associative array
if ($result_successful_trades->num_rows > 0) {
    $successful_trades_data = $result_successful_trades->fetch_assoc();
    $successful_trades = $successful_trades_data['successful_trades'];
} else {
    $successful_trades = 0; // Default value if no successful trades found
}

// Close the database connection
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barter System - Profile</title>
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
      0% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.2);
      }
      100% {
        transform: scale(1);
      }
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

    .adm{
      position: absolute;
      top: 20px;
      right: 20px;
    }

    .adm button {
      padding: 8px 20px;
      background-color: #3498db;
      color: white;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .adm button:hover {
      background-color: #2980b9;
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
    <h1>Barter System - Profile</h1>
  </header>

  <nav>
    <a href="dashboard.html">Dashboard</a>
    <a href="my_trades.php">My Trades</a>
    <a href="../users.php">Messages</a>
    <a href="setting.html">Settings</a>
    <a href="../logout.php">Logout</a>
  </nav>

  <main>
    <section id="profile-section">
      <h2>My Profile</h2>
      <div class="profile-info">
        <div>
          <h3>Personal Information</h3>
          <p><strong>Full Name:</strong> <?php echo $fullname; ?></p>
          <p><strong>Email:</strong> <?php echo $email; ?></p>
          <p><strong>Location:</strong> <?php echo $location; ?></p>
          <p><strong>User Type:</strong> <?php echo $user_type; ?></p>
          <p><strong>Gender:</strong> <?php echo $gender; ?></p>
        </div>
        <div>
          <h3>Trade History</h3>
          <p><strong>Total Trades:</strong> <?php echo $total_trades; ?></p>
          <p><strong>Successful Trades:</strong> <?php echo $successful_trades; ?></p>
        </div>
      </div>
    </section>
  </main>

  <?php if ($user_type === "admin"): ?>
    <a href="admin.php" class="adm"><button>Admin Only</button></a>
  <?php endif; ?>

  <footer>
    &copy; Barter System
  </footer>
</body>
</html>
