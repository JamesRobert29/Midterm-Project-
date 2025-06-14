<?php  

include '../backend/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['send'])){

   $msg_id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $message = $_POST['message'];
   $message = filter_var($message, FILTER_SANITIZE_STRING);

   $verify_contact = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $verify_contact->execute([$name, $email, $number, $message]);

   if($verify_contact->rowCount() > 0){
      $warning_msg[] = 'message sent already!';
   }else{
      $send_message = $conn->prepare("INSERT INTO `messages`(id, name, email, number, message) VALUES(?,?,?,?,?)");
      $send_message->execute([$msg_id, $name, $email, $number, $message]);
      $success_msg[] = 'message send successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact Us</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include '../backend/user_header.php'; ?>

<!-- contact section starts  -->

<section class="contact">

   <div class="row">
      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>
      <form action="" method="post">
         <h3>get in touch</h3>
         <input type="text" name="name" required maxlength="50" placeholder="enter your name" class="box">
         <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
         <input type="number" name="number" required maxlength="10" max="9999999999" min="0" placeholder="enter your number" class="box">
         <textarea name="message" placeholder="enter your message" required maxlength="1000" cols="30" rows="10" class="box"></textarea>
         <input type="submit" value="send message" name="send" class="btn">
      </form>
   </div>

</section>

<!-- contact section ends -->

<!-- faq section starts  -->

<section class="faq" id="faq">

   <h1 class="heading">FAQ</h1>

   <div class="box-container">

      <div class="box active">
         <h3><span>How to cancel appointment?</span><i class="fas fa-angle-down"></i></h3>
         <p>Go to the website and sign in. Select the scheduled property visits or meetings. Click the appointment and cancel it.</p>
      </div>

      <div class="box active">
         <h3><span>When will I get the possession?</span><i class="fas fa-angle-down"></i></h3>
         <p>Keys will be handed over upon full payment and signing of final documents. </p>
      </div>

      <div class="box">
         <h3><span>Where can I pay the rent?</span><i class="fas fa-angle-down"></i></h3>
         <p>Rent can be paid directly through the website/app via online payment methods(Gcash, bank transfer,credit/debit card).</p>
      </div>

      <div class="box">
         <h3><span>How to contact with the buyers?</span><i class="fas fa-angle-down"></i></h3>
         <p>Interested buyers can contact us via chat on website or through mobile number or email address. We will respond within 24 hours to inquiries and schedule viewings.</p>
      </div>

      <div class="box">
         <h3><span>Why my listing not showing up?</span><i class="fas fa-angle-down"></i></h3>
         <p>If your listing is not showing up, it could be due to pending approval, incomplete information, not published yet, site policy violation and technical issues.</p>
      </div>

      <div class="box">
         <h3><span>Why invest in AstaLaVista Real Estate property?</span><i class="fas fa-angle-down"></i></h3>
         <p>AstaLaVista provides comfortable living, ready for occupancy/move-in ready and strong investment potential.</p>
      </div>

   </div>

</section>

<!-- faq section ends -->










<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include '../backend/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>