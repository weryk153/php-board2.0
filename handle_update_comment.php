<?php
  require_once('./conn.php');
  
  if (
    isset($_POST['content']) &&
    !empty($_POST['content']) &&
    isset($_POST['comment_id']) &&
    !empty($_POST['comment_id']) &&
    isset($_POST['user_id']) &&
    !empty($_POST['user_id'])
  ) {
    $content = $_POST['content'];
    $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    $sql = "UPDATE k_comments SET content = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $content, $comment_id, $user_id);
    if ($stmt->execute()) {
      header('Location: ./index.php');
    } else {
      echo "failed, " . $conn->error;
    }
  } else {
    echo "<script>
            alert('請輸入內容');
            window.location = '" . $_SERVER['HTTP_REFERER'] . "';
          </script>";
  }
  $conn->close();
?>