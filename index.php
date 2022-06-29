<?php 
  //when user already logged in with his/her account in the same browser redirect to users page
  session_start();
  if(isset($_SESSION['unique_id'])){
    header("location: users.php");
  }
?>

<!-- wrap up the header part of html and make it a file header.php -->
<?php include_once "header.php"; ?> 
<body>
  <div class="wrapper">
    <section class="form signup">
      <header>Realtime Chat Application</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <!-- enctype="multipart/form-data" ->>>  is an encoding type that allows files to be sent through a POST. 
        Quite simply, without this encoding the files cannot be sent through POST -->
        <div class="error-text"></div>  
        <!-- if any error occure during registration that error will occure by using upper div-->
        <div class="name-details">
          <div class="field input">
            <label>First Name</label>
            <input type="text" name="fname" placeholder="First name" required>
          </div>
          <div class="field input">
            <label>Last Name</label>
            <input type="text" name="lname" placeholder="Last name" required>
          </div>
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
        <div class="field image">
          <label>Select Image</label>
          <!-- it will accept files that extension should png ,gif etc.. -->
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
      <div class="link">Already signed up? <a href="login.php">Login now</a></div>
    </section>
  </div>

  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/signup.js"></script>

</body>
</html>
