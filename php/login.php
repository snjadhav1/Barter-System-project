<?php 
    session_start();
    include_once "config.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (!empty($email) && !empty($password)) {
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            if (mysqli_num_rows($sql) > 0) {
                $row = mysqli_fetch_assoc($sql);
                $user_pass = md5($password);

                if ($user_pass === $row['password']) {
                    $status = "Active now";
                    $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
                    if ($sql2) {
                        $_SESSION['unique_id'] = $row['unique_id'];
                        $_SESSION['email'] = $row['email']; 
                        echo "success";
                    } else {
                        echo "Something went wrong. Please try again!";
                    }
                } else {
                    echo "Email or Password is Incorrect!";
                }
            } else {
                echo "$email - This email does not exist!";
            }
        } else {
            echo "All input fields are required!";
        }
    } else {
        echo "Invalid request method";
    }
?>
