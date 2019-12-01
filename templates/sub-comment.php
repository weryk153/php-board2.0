<div class='post__childs'>
<?php
  $parent_id = $row_comment['id'];
  $sql_sub = "SELECT c.content, c.created_at, c.id, c.user_id, k_users.nickname 
    FROM k_comments as c JOIN k_users ON c.user_id = k_users.id 
    WHERE c.parent_id = ?
    ORDER BY created_at 
    ASC";

  $stmt = $conn->prepare($sql_sub);
  $stmt->bind_param("i", $parent_id);
  $stmt->execute();
  $result_sub_c = $stmt->get_result();
  if ($result_sub_c->num_rows > 0) {
    while ($row_sub_c = $result_sub_c->fetch_assoc()) {
      $chr_escape = escape($row_sub_c['content']);
      $content_with_br = str_replace(chr(13).chr(10), "<br />", $chr_escape);
      if ($row_comment['user_id'] === $row_sub_c['user_id']) {
        echo "<div class='post__child same-post__child'>";
      } else {
        echo "<div class='post__child'>";
      }
      if ($user_id == $row_sub_c['user_id']) {
        echo renderBtn($user_id, $row_sub_c['id'],null);
      }
      echo "<div class='post-header'>";
      echo   "<div class='post-author'>" . escape($row_sub_c['nickname']) . "</div>";
      echo   "<div class='post-timestamp'>" . $row_sub_c['created_at'] . "</div>";
      echo "</div>";
      echo "<div class='post-content'>$content_with_br</div>";
      echo "</div>";
    }
  }
  if ($username) {
    echo "<form class='sub-board-comment' method='POST' action='./handle_add_comment.php'>";
    echo   "<textarea name='content' class='sub-textarea' placeholder='留言內容...' style='outline:none;'></textarea>";
    echo   "<input type='hidden' name='user_id' value='$user_id'>";
    echo   "<input type='hidden' name='parent_id' value='$parent_id'>";
    echo   "<input type='submit' class='btn btn-add' value='送出'>";
    echo "</form>";
  } ?>
</div>
