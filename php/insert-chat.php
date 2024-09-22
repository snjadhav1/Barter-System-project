<?php 
session_start();
if(isset($_SESSION['unique_id'])){
    include_once "config.php";
    
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    if(!empty($message)){
        // Insert the message into the database
        $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                VALUES ($incoming_id, $outgoing_id, '$message')";
        $result = mysqli_query($conn, $sql);
        
        if($result) {
            // Insert a notification into the notification table for the user receiving the message
            $notification_content = " " . $message; // Include the message content in the notification
            $notification_insert_query = "INSERT INTO notifications (user_id, by_user, content ) 
                                          VALUES ('$incoming_id', '$outgoing_id', '$notification_content')";
            if(mysqli_query($conn, $notification_insert_query)) {
                echo "Notification saved successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    header("location: ../login.php");
}
?>