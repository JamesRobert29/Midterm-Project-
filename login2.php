<?php

include 'components/connect.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); 
   $password = sha1($_POST['pass']);
   $password = filter_var($password, FILTER_SANITIZE_STRING); 

   $select_admins = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ? LIMIT 1");
   $select_admins->execute([$name, $password]);
   $row = $select_admins->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../backend/admin_style.css">

</head>
<body style="padding-left: 0;">

<!-- login section starts  -->

<?php
$success = false;
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['name'] ?? '';
    $password = $_POST['pass'] ?? '';

    // Simple login check
    if ($username === 'group4_admins' && $password === 'admin_panel4') {
        $success = true;
        // Meta refresh will be added below in HTML if success
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<section class="form-container" style="min-height: 100vh;">

   <?php if ($success): ?>
      <!-- Redirect after 2 seconds -->
      <meta http-equiv="refresh" content="2;url=dashboard2.php">
      <h3 style="color: green;">Login successful! Redirecting to dashboard...</h3>
   <?php else: ?>
      <form action="" method="POST">
         <h3>welcome back!</h3>
         <p>AstaLaVista Real Estate Admin Panel Server</p>

         <?php if (!empty($error)): ?>
            <p style="color: red;"><?= $error ?></p>
         <?php endif; ?>

         <input type="text" name="name" placeholder="enter username" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" placeholder="enter password" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="login now" class="btn">
         <a href="home.php" class="btn">Back to Home</a>

      </form>
   <?php endif; ?>

</section>
<!-- login section ends -->

</body>
</html>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include '../backend/messages2.php'; ?>

</body>
</html>  