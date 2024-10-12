<?php

require_once 'src/pdo.php';

session_start();

$errors = [];

if ($_POST['_method'] === 'delete') {
    $withdrawal_visit_datetime = $_SESSION['WITHDRAWAL_VISIT_DATETIME'];
    if (!isset($withdrawal_visit_datetime) || strtotime($withdrawal_visit_datetime) < time() - 60) {
        $errors['withdrawal_visit_datetime'] = 'タイムアウトしました。再度実行してください。';
        $_SESSION['WITHDRAWAL_VISIT_DATETIME'] = date('Y-m-d H:i:s');
    } else {
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_STR);
        $stmt->execute();
        session_destroy();
        unset($_SESSION);
        header('Location: index.php');
        exit;
    }
} else {
    $_SESSION['WITHDRAWAL_VISIT_DATETIME'] = date('Y-m-d H:i:s');
}
?>

<?php if (!isset($_SESSION['user_id'])): ?>
    <?php header('Location: index.php'); exit; ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>退会</title>
</head>
<body>
    <h1>退会</h1>
    ID: <?php echo htmlspecialchars($_SESSION['user_id']); ?><br />
    <?php if (isset($errors['withdrawal_visit_datetime'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errors['withdrawal_visit_datetime']); ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="hidden" name="_method" value="" />
        <script>
            function withdrawal() {
                if (confirm('退会しますか？')) {
                    document.querySelector('input[name="_method"]').value = 'delete';
                    document.querySelector('form').submit();
                }
            }
        </script>
        <input type="submit" value="退会" onclick="javascript:withdrawal();" />
        <p>
            退会の有効期限は1分間です。<br />
            <?php
            $expiration_time = strtotime($_SESSION['WITHDRAWAL_VISIT_DATETIME']) + 60;
            $expiration_formatted = date('Y-m-d H:i:s', $expiration_time);
            echo htmlspecialchars($expiration_formatted) . "まで有効です。";
            ?>
        </p>
    </form>
</body>
</html>
