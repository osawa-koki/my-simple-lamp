<?php
session_start();

if (isset($_SESSION['user_id'])) {
    session_destroy();
    setcookie(session_name(), '', time() - 42000, '/');
    unset($_SESSION['user_id']);
    echo 'サインアウトしました。';
} else {
    echo 'サインインされていません。';
}

?>
<a href="sign_in.php">サインイン画面</a>に戻る。
