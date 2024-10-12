<?php
require_once 'src/pdo.php';
require_once 'src/validate.php';

session_start();
session_regenerate_id(true);
$session_exists = isset($_SESSION['user_id']);
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['_method'] === 'patch') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $comment = $_POST['comment'];
    $errors = validate_user_params($id, $name, $email, $birthday, $comment, 'dummy-password');

    if (!isset($_SESSION['user_id'])) {
        $errors['mypage'] = 'サインインしてください。';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE users SET id = :id, name = :name, email = :email, birthday = :birthday, comment = :comment WHERE id = :existing_id");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':existing_id', $_SESSION['user_id'], PDO::PARAM_STR);
        $stmt->execute();

        if ($_SESSION['user_id'] !== $_POST['id']) {
            $_SESSION['user_id'] = $_POST['id'];
        }
    } else {
        $errors['mypage'] = '入力内容に不備があります。';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>マイページ</title>
</head>
<body>

<?php if (!$session_exists): ?>
    <p>サインインしてください。</p>
    <table>
        <tr>
            <td><a href="sign_in.php">サインイン</a></td>
            <td><a href="sign_up.php">サインアップ</a></td>
        </tr>
    </table>
<?php endif; ?>

<?php if ($session_exists): ?>
    <?php
    $stmt = $pdo->prepare("SELECT id, name, email, birthday, comment, created_at, updated_at FROM users WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();
    ?>
    <p>ようこそ、<?php echo htmlspecialchars($user['name']); ?>さん。</p>
    <?php if (!empty($errors)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errors['mypage']); ?></p>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="hidden" name="_method" value="patch" />
        <table>
            <tr>
                <td>ユーザーID</td>
                <td>
                    <input type="text" name="id" value="<?php echo htmlspecialchars($user['id']); ?>" pattern="^[a-zA-Z0-9_\-]{8,36}$" />
                </td>
            </tr>
            <tr>
                <td>ユーザー名</td>
                <td>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" />
                </td>
            </tr>
            <tr>
                <td>メールアドレス</td>
                <td>
                    <input type="text" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required />
                </td>
            </tr>
            <tr>
                <td>誕生日</td>
                <td>
                    <input type="date" name="birthday" value="<?php echo htmlspecialchars($user['birthday']); ?>" required />
                </td>
            </tr>
            <tr>
                <td>コメント</td>
                <td>
                    <textarea name="comment"><?php echo htmlspecialchars($user['comment']); ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="更新" /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <script>
                        function signOut() {
                            if (confirm('サインアウトしますか？')) {
                                window.location.href = 'sign_out.php';
                            }
                        }
                    </script>
                    <button type="button" onclick="javascript:signOut();">サインアウト</button>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="button" onclick="javascript:window.location.href = 'withdrawal.php';">退会</button>
                </td>
            </tr>
        </table>
    </form>
<?php endif; ?>

</body>
</html>
