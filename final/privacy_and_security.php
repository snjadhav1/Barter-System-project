<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy and Security</title>
    <style>
        body {
            background-image: url('gra.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .privacy-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }

        .privacy-content {
            line-height: 1.6;
        }

        .change-password-panel {
            display: none;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .show-panel {
            display: block;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        footer {
            margin-top: 20px;
            text-align: center;
        }

        footer a {
            background-color: #6c757d;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        footer a:hover {
            background-color: #495057;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="privacy-container">
    <h2>Privacy and Security</h2>
    <div class="privacy-content">
        <p>Your privacy and security are fundamental to us at Barter System. This page details how we handle your personal information and ensure the security of our platform.</p>
        <h3>Information We Collect</h3>
        <p>At Barter System, we collect information necessary for facilitating trades between users. This includes details provided during registration, such as your name, email address, location, and trade preferences. Additionally, we may collect information about your trade history and interactions on our platform.</p>
        <h3>How We Use Your Information</h3>
        <p>We use the information you provide to facilitate trades, personalize your experience, and improve our services. Your data may also be used for communication purposes, such as notifications about trade opportunities or updates to our platform.</p>
        <h3>Security Measures</h3>
        <p>Security is a top priority at Barter System. We employ industry-standard security measures to protect your personal information from unauthorized access, disclosure, and misuse. Our platform uses encryption protocols to secure data transmission, and we regularly update our systems to address potential vulnerabilities.</p>
        <h3>Third-Party Links</h3>
        <p>While using Barter System, you may encounter links to third-party websites or services. These links are provided for your convenience and may have their own privacy policies. We are not responsible for the privacy practices or content of these third-party sites.</p>
        <h3>Policy Updates</h3>
        <p>We may update our privacy and security policy periodically to reflect changes in our practices or regulatory requirements. Any updates will be posted on this page, and we encourage you to review this policy regularly.</p>
        <p>If you have any questions or concerns about our privacy and security practices, please don't hesitate to contact us.</p>
    </div>
    <div id="passwordPanel" class="change-password-panel">
        <h2>Change Password</h2>
        <form method="post" action="">
            <label for="old_password">Old Password:</label>
            <input type="password" id="old_password" name="old_password">

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password">

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password">

            <input type="submit" value="Submit">
        </form>
    </div>
    <button onclick="togglePanel()">Change Password</button>
</div>

<footer>
    <a href="setting.html">Back</a>
</footer>

<script>
    function togglePanel() {
        var panel = document.getElementById("passwordPanel");
        panel.classList.toggle("show-panel");
    }
</script>

</body>
</html>
