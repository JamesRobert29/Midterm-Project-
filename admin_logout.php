<?php

include '../backend/connect.php';

setcookie('admin_id', '', time() - 1, '/');

header('location: ../backend/login2.php');

?>