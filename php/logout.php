

<?php
// Logout script
if (isset($_SESSION['unique_id']) && ($_SESSION['email'])) {
    include_once "config.php";

    if (isset($_GET['logout_id'])) {
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        $status = "Offline now";
        $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$logout_id}");

        if ($sql) {
            session_unset();
            session_destroy();
            header("Location:../login.php");
            exit();
        } else {
            // Handle the case when the SQL query fails
            echo "An error occurred while updating the user status.";
        }
    } else {
        header("Location:../final/dashboard.html");
        exit();
    }
} else {
    header("Location:../login.php");
    exit();
}