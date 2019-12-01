<?php
  session_start();
  $username = '';
  $user_id = '';
  if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $is_login = true;
    $username = $_SESSION['username'];
    $nickname = getnickName($conn, $username);
    $user_id = getuserId($conn, $username);
  }
?>