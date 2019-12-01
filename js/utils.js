function escapeHtml(unsafe) {
  return unsafe
   .replace(/&/g, "&amp;")
   .replace(/</g, "&lt;")
   .replace(/>/g, "&gt;")
   .replace(/"/g, "&quot;")
   .replace(/'/g, "&#039;");
}

function getmainPost(nickname, userId, comment_id, content, created_at) {
  const mainPost = `
    <div class='post'>
      <div class='post-edit'>
        <form class="edit" method="POST" action="./update_comment.php">
          <input type="hidden" name="user_id" value="${userId}">
          <input type="hidden" name="comment_id" value="${comment_id}">
          <input type='submit' class='btn' value='編輯'>
        </form>
        <form class="edit-delete" method="POST" action="./delete_comment.php">
          <input type="hidden" name="user_id" value="${userId}">
          <input type="hidden" name="comment_id" value="${comment_id}">
          <input type='submit' class='btn btn-delete' value='刪除'>
        </form>
      </div>
      <div class='post-header'>
        <div class='post-author'>${escape(nickname)}</div>
        <div class='post-timestamp'>${created_at}</div>
      </div>
      <div class='post-content'>${escapeHtml(content)}</div>
      <div class="post__childs">
        <form class="sub-board-comment" method="POST" action="./handle_add_comment.php">
          <textarea name="content" class="sub-textarea" placeholder="留言內容" style="outline:none;"></textarea>
          <input type="hidden" name="user_id" value="${userId}">
          <input type="hidden" name="parent_id" value="${comment_id}">
          <input type='submit' class='btn btn-add' value='送出'>
        </form>
      </div>
    </div>`;

  return mainPost;
}

function getsubPost(nickname, userId, comment_id, content, created_at, thesameId) {
  const thesame = (thesameId === userId) ? 'same-post__child' : '';
  const subPost = `
    <div class='post__child ${thesame}'>
      <div class='post-edit'>
        <form class="edit" method="POST" action="./update_comment.php">
          <input type="hidden" name="user_id" value="${userId}>">
          <input type="hidden" name="comment_id" value="${comment_id}">
          <input type='submit' class='btn' value='編輯'>
        </form>
        <form class="edit-delete" method="POST" action="./delete_comment.php">
          <input type="hidden" name="user_id" value="${userId}">
          <input type="hidden" name="comment_id" value="${comment_id}">
          <input type='submit' class='btn' value='刪除'>
        </form>
      </div>
      <div class='post-header'>
        <div class='post-author'>${nickname}</div>
        <div class='post-timestamp'>${created_at}</div>
      </div>
      <div class='post-content'>${escapeHtml(content)}</div>
    </div>`;
  return subPost;
}

$(document).ready(() => {
  $(document).on('submit', '.board-comment, .sub-board-comment', (e) => {
    e.preventDefault();
    const content = $(e.target).parent().find('textarea[name="content"]').val();
    const userId = $(e.target).parent().find('input[name="user_id"]').val();
    const thesameId = $(e.target).parent().parent().find('div[class="main"]').find('form[class="edit"]').find('input[name="user_id"]').val();
    const parentId = $(e.target).parent().find('input[name="parent_id"]').val();
    const subForm = $(e.target).closest('form');
    $.ajax({
      type: 'POST',
      url: 'handle_add_comment.php',
      data: {
        content: content,
        user_id: userId,
        parent_id: parentId
      },
    }).done((response) => {
        const res = JSON.parse(response);
        const [nickname, comment_id, created_at] = [res.nickname, res.comment_id, res.created_at];
        if (parentId === '0') {
          $('.textarea').val('');
          $('.board-message').prepend(getmainPost(nickname, userId, comment_id, content, created_at));
        } else {
          $('.sub-textarea').val('');
          subForm.before(getsubPost(nickname, userId, comment_id, content, created_at, thesameId));
        }
      }
    )
  });
  $('.board-message').submit((e) => {
    if ($(e.target).hasClass('edit-delete')) {
      e.preventDefault();
      const commentId = $(e.target).find('input[name=comment_id]').val();
      const userId = $(e.target).find('input[name=user_id]').val();
      $.ajax({
        type: 'POST',
        url: 'handle_delete_comment.php',
        data: {
          comment_id: commentId,
          user_id: userId
        },
        success: function(resp) {
          let res = JSON.parse(resp);
          if (res.result === 'success') {
          $(e.target).parent().parent().remove();
          }
        }
      });
    }
  });
});


