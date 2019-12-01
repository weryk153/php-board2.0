<?php
  session_start();
  require_once('./conn.php');
  
  if (
    isset($_POST['nickname']) && 
    isset($_POST['username']) && 
    isset($_POST['password']) && 
    !empty($_POST['nickname']) &&
    !empty($_POST['username']) &&
    !empty($_POST['password'])
  ) { 
    $nickname = $_POST['nickname'];
    $username = $_POST['username'];
    $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO k_users(nickname, username, password) VALUE(?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nickname, $username, $hash);
    if ($stmt->execute()) {
      $_SESSION['username'] = $username;
      echo "<script>
      alert('註冊成功');
      window.location = 'index.php';
      </script>";
    } else {
      header('Location: ./register.php');
    }
  } else {
    echo "<script>
    alert('請檢查資料');
    window.location = 'register.php';
    </script>";
  }
  $conn->close();
?>