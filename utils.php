<?php 

  function escape ($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
  }

  function getNickname($conn, $username) {
    $sql = "SELECT * FROM k_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      return $row['nickname'];
    } else {
      return null;
    }
  }

  function getUserId($conn, $username) {
    $sql = "SELECT * FROM k_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      return $row['id'];
    } else {
      return null;
    }
  }

  function renderBtn($user_id, $comment_id, $mainComment) {
    if ($mainComment) {
      $mainComment = 'main';
    }
    return "
      <div class='post-edit $mainComment'>
        <form class='edit' method='POST' action='./update_comment.php'>
          <input type='hidden' name='user_id' value='$user_id'>
          <input type='hidden' name='comment_id' value='$comment_id'>
          <input type='submit' class='btn' value='編輯'>
        </form>
        <form class='edit-delete' method='POST' action='./delete_comment.php'>
          <input type='hidden' name='user_id' value='$user_id'>
          <input type='hidden' name='comment_id' value='$comment_id'>
          <input type='submit' class='btn' value='刪除'>
        </form>
      </div>
    ";}
?>