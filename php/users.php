<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "<div style='color: green;'><p>No users are available to chat</p></div>";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }

   

    echo $output;
?>
