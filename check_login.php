<?php
  session_start();
  $username = '';
  $user_id = '';
  if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $is_login = true;
    $username = $_SESSION['username'];
    $nickname = getNickname($conn, $username);
    $user_id = getUserId($conn, $username);
  }
?>