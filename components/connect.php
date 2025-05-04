<?php

   $db_name = 'mysql:host=localhost;dbname=home_db';
   $db_user_name = 'root';
   $db_user_pass = '';

   $conn = new PDO($db_name, $db_user_name, $db_user_pass);

   function create_unique_id(){
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $char_len = strlen($characters);
      $rand_str = '';
    for ($i = 0; $i < 20; $i++) {
          $rand_str .= $characters[mt_rand(0, $char_len - 1)];
      }
    return $rand_str;
  }

?>