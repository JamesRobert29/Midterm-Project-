<?php

include '../backend/components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   //header('location:login2.php');
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $select_images = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
      $select_images->execute([$delete_id]);
      while($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)){
         $image_01 = $fetch_images['image_01'];
         $image_02 = $fetch_images['image_02'];
         $image_03 = $fetch_images['image_03'];
         $image_04 = $fetch_images['image_04'];
         $image_05 = $fetch_images['image_05'];
         unlink('../uploaded_files/'.$image_01);
         if(!empty($image_02)){
            unlink('../uploaded_files/'.$image_02);
         }
         if(!empty($image_03)){
            unlink('../uploaded_files/'.$image_03);
         }
         if(!empty($image_04)){
            unlink('../uploaded_files/'.$image_04);
         }
         if(!empty($image_05)){
            unlink('../uploaded_files/'.$image_05);
         }
      }
      $delete_listings = $conn->prepare("DELETE FROM `property` WHERE id = ?");
      $delete_listings->execute([$delete_id]);
      $success_msg[] = 'Listing deleted!';
   }else{
      $warning_msg[] = 'Listing deleted already!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Listings</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../backend/admin_style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include '../backend/admin_header.php'; ?>
<!-- header section ends -->


   <!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Listings</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="../backend/admin_style.css">
</head>
<body>
   
<!-- header section starts -->
<?php include '../backend/admin_header.php'; ?>
<!-- header section ends -->

<section class="listings">

   <h1 class="heading">All Listings</h1>

   <form action="" method="POST" class="search-form">
      <input type="text" name="search_box" placeholder="Search listings..." maxlength="100" required>
      <button type="submit" class="fas fa-search" name="search_btn"></button>
   </form>

   <div class="box-container">

   <?php
      if (isset($_POST['search_box']) || isset($_POST['search_btn'])) {
         $search_box = $_POST['search_box'];
         $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
         $select_listings = $conn->prepare("SELECT * FROM `property` WHERE property_name LIKE ? OR address LIKE ? ORDER BY date DESC");
         $search_term = "%{$search_box}%";
         $select_listings->execute([$search_term, $search_term]);
      } else {
         $select_listings = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC");
         $select_listings->execute();
      }

      if ($select_listings->rowCount() > 0) {
         while ($fetch_listing = $select_listings->fetch(PDO::FETCH_ASSOC)) {
            $listing_id = $fetch_listing['id'];

            // Fetch owner info (optional)
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_user->execute([$fetch_listing['user_id']]);
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

            // Count how many images exist
            $total_images = 0;
            for ($i = 1; $i <= 5; $i++) {
               if (!empty($fetch_listing["image_0{$i}"])) {
                  $total_images++;
               }
            }
   ?>

   <div class="box">
      <div class="thumb">
         <p><i class="far fa-image"></i><span><?= $total_images; ?></span></p>
         <?php if (!empty($fetch_listing['image_01'])): ?>
            <img src="../backend/uploaded_files/<?= htmlspecialchars($fetch_listing['image_01']); ?>" alt="property image">
         <?php else: ?>
            <img src="../images/default.png" alt="no image"> <!-- fallback image if missing -->
         <?php endif; ?>
      </div>

      <p class="price"><i class="fas fa-peso-sign"></i><?= htmlspecialchars($fetch_listing['price']); ?></p>
      <h3 class="name"><?= htmlspecialchars($fetch_listing['property_name']); ?></h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><?= htmlspecialchars($fetch_listing['address']); ?></p>

      <form action="" method="POST">
         <input type="hidden" name="delete_id" value="<?= $listing_id; ?>">
         <a href="view_property.php?get_id=<?= $listing_id; ?>" class="btn">View Property</a>
         <input type="submit" value="Delete Listing" onclick="return confirm('Delete this listing?');" name="delete" class="delete-btn">
      </form>
   </div>

   <?php
         }
      } elseif (isset($_POST['search_box']) || isset($_POST['search_btn'])) {
         echo '<p class="empty">No results found!</p>';
      } else {
         echo '<p class="empty">No property posted yet!</p>';
      }
   ?>

   </div>

</section>

</body>
</html>

</section>


















<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../backend/admin_script.js"></script>

<?php include '../backend/messages2.php'; ?>

</body>
</html>