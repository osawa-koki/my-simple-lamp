<?php
require_once 'src/pdo.php';
require_once 'src/validate.php';

session_start();
session_regenerate_id(true);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $encrypted_password = hash('sha3-256', $password);

    $errors = validate_user_params($id, 'dummy-name', 'dummy-email@example.com', '1990-01-01', 'dummy-comment', $password);

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE id = :id AND password = :password");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':password', $encrypted_password, PDO::PARAM_STR);
        $stmt->execute();

        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: mypage.php');
            exit;
        } else {
            $errors['sign_in'] = 'ユーザーIDまたはパスワードが正しくありません。';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>サインイン</title>
</head>
<body>
    <h1>サインイン</h1>
    <?php if (!empty($errors)): ?>
        <p style="color: red;">入力内容に不備があります。</p>
    <?php endif; ?>
    <a href="sign_up.php">サインアップ</a>はこちら。
    <hr />
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <table>
            <tr>
                <td>
                    <label for="id">ユーザーID:</label>
                </td>
                <td>
                    <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" required>
                </td>
                <td>
                    <?php if (isset($errors['id'])): ?>
                        <p style="color: red;"><?php echo htmlspecialchars($errors['id']); ?></p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="password">パスワード:</label>
                </td>
                <td>
                    <input type="password" name="password" required />
                </td>
                <td>
                    <?php if (isset($errors['password'])): ?>
                        <p style="color: red;"><?php echo htmlspecialchars($errors['password']); ?></p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <input type="submit" value="サインイン" />
                </td>
            </tr>
        </table>
    </form>
    <?php if (isset($errors['sign_in'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errors['sign_in']); ?></p>
    <?php endif; ?>
</body>
</html>
