<?php
  require_once('conn.php');
  require_once('utils.php');
  require_once('check_login.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <title>K-hw2、3</title>
  </head>
  <body>
    <?php include_once('templates/navbar.php'); ?>
    <h1 class="board-title">本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</h1>
    <div class="board">
      <form class="board-comment" method="POST" action="./handle_add_comment.php">
        <textarea name="content" class="textarea" placeholder="留言內容..." style="outline:none;"></textarea>
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <input type="hidden" name="parent_id" value="0">
        <?php 
          if ($username) {
            echo "<input type='submit' class='btn btn-add' value='送出'>";
          } else {
            echo "<input type='submit' class='btn' value='請先登入' disabled>";
          }
        ?>
      </form>
      <div class="board-message">
      <?php
        include_once('handle_pagination.php');
        include_once('templates/comment.php');
      ?>
      </div>
      <?php include_once('templates/board-pagination.php')?>
    </div>
    <script src="js/utils.js"></script>
  </body>
</html>