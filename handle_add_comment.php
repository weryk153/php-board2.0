<?php
  require_once('./conn.php');
  require_once('utils.php');
  include_once('check_login.php');
  
  if (isset($_POST['content']) && !empty($_POST['content'])) {
    $content = $_POST['content'];
    $user_id = $_POST['user_id'];
    $parent_id = $_POST['parent_id'];

    $sql = "INSERT INTO k_comments(content, user_id, parent_id) VALUE(?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $content, $user_id, $parent_id);
    if ($stmt->execute()) {
      $last_id = $stmt->insert_id;
      $sql = "SELECT * FROM k_comments WHERE id = $last_id";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $comment_id = $last_id;
      $created_at = $row['created_at'];

      $arr = array('result' => 'success', 'comment_id' => $comment_id, 'nickname' => $nickname, 'created_at' => $created_at);
      echo json_encode($arr);
    } else {
      echo json_encode(array(
        'result' => 'failure'
      ));
    }
    $conn->close();
  }
?>