<?php
  $sql = "SELECT c.content, c.created_at, c.id, c.user_id, k_users.nickname FROM k_comments as c JOIN k_users ON c.user_id = k_users.id WHERE c.parent_id = 0 ORDER BY created_at DESC LIMIT ?, ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $data_start, $page_limit);
  $stmt->execute();
  $result_comment = $stmt->get_result();
  if ($result_comment->num_rows > 0) {
    while ($row_comment = $result_comment->fetch_assoc()) {
      $chr_escape = escape($row_comment['content']);
      $content_with_br = str_replace(chr(13).chr(10), "<br />", $chr_escape);
      echo "<div class='post'>";
      if ($user_id == $row_comment['user_id']) {
        echo renderBtn($user_id, $row_comment['id'], true);
      }
      echo "<div class='post-header'>";
      echo   "<div class='post-author'>" . escape($row_comment['nickname']) . "</div>";
      echo   "<div class='post-timestamp'>" . $row_comment['created_at'] . "</div>";
      echo "</div>";
      echo "<div class='post-content'>$content_with_br</div>";
      include('templates/sub-comment.php');
      echo "</div>";
    }
  }
?>