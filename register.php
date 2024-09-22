<?php session_start(); if(isset($_SESSION['unique_id'])){ header("location: login.php"); exit();} ?>
<?php include_once "header.php"; ?>
<body>
    <div class="wrapper">
        <section class="form signup">
            <header>Register</header>
            <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                <div class="field input">
                    <label>Full Name</label>
                    <input type="text" name="fullname" placeholder="Enter your full name" required>
                </div>
                <div class="field input">
                    <label>Email Address</label>
                    <input type="text" name="email" placeholder="Enter your email" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter new password" required>
                    <i class="fas fa-eye"></i>
                </div>
                
                    <div class="field input">
                   <label> Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Reenter new password" required>
                   <i class="fas fa-eye"></i>
                   </div>
                
                <div class="field input">
                    <label>Location</label>
                    <input type="text" name="location" placeholder="Enter your location" required>
                </div>
                <div class="field input">
                    <label>User Type</label>
                    <select name="user_type" required>
                        <option value="">Select User Type</option>
                        <option value="business">business</option>
                        <option value="individual">individual</option>
                    </select>
                </div>
                <div class="field input">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Register">
                </div>
            </form>
            <div class="link">Already signed up? <a href="login.php">Login now</a></div>
        </section>
    </div>
    <script src="javascript/pass-show-hide.js"></script>
    <script src="javascript/signup.js"></script>
</body>
</html>