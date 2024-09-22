<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
    exit();
  }
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
              $output = "";
            }
          ?>
    
          <div class="details">
            <span><?php echo $row['fullname'] ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        
      </header>
      <div class="search">
        <span class="text">Select an user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
  
      </div>
    </section>
    <footer>
    <button id="backButton" style='background-color: green; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;'>Back</button>

    <script>
        // Function to go back to the final/dashboard.html page
        function goBack() {
            window.location.href = 'final/dashboard.html';
        }

        // Attach click event listener to the button
        document.getElementById('backButton').addEventListener('click', goBack);
    </script>
  </footer>
  </div>

  <script src="javascript/users.js"></script>

  

</body>
</html>