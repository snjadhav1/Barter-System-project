<?php
session_start();
include_once "config.php";

$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$location = mysqli_real_escape_string($conn, $_POST['location']);
$user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
$gender = mysqli_real_escape_string($conn, $_POST['gender']);

if(!empty($fullname) && !empty($email) && !empty($password) && !empty($location) && !empty($user_type) && !empty($gender)) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if(mysqli_num_rows($sql) > 0) {
            echo "$email - This email already exists!";
        } else {
            $ran_id = rand(time(), 100000000);
            $status = "Active now";
            $encrypt_pass = md5($password);
            $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fullname, email, password, location, user_type, gender, status) VALUES ({$ran_id}, '{$fullname}', '{$email}', '{$encrypt_pass}', '{$location}', '{$user_type}', '{$gender}', '{$status}')");
            if($insert_query) {
                $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                if(mysqli_num_rows($select_sql2) > 0) {
                    $result = mysqli_fetch_assoc($select_sql2);
                    $_SESSION['unique_id'] = $result['unique_id'];
                    echo "success";
                } else {
                    echo "This email address does not exist!";
                }
            } else {
                echo "Something went wrong. Please try again!";
            }
        }
    } else {
        echo "$email is not a valid email!";
    }
} else {
    echo "All input fields are required!";
}
?>