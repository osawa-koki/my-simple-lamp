<?php
require_once 'src/pdo.php';
require_once 'src/validate.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $comment = $_POST['comment'];
    $password = $_POST['password'];
    $encrypted_password = hash('sha3-256', $password);

    $errors = validate_sign_up($id, $name, $email, $birthday, $comment, $password);

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE id = :id OR email = :email");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $errors['duplicate'] = 'このユーザーIDまたはメールアドレスは既に使用されています。';
            } else {
                $stmt = $pdo->prepare("INSERT INTO users (id, name, email, birthday, comment, password) VALUES (:id, :name, :email, :birthday, :comment, :password)");
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':password', $encrypted_password, PDO::PARAM_STR);
                $stmt->execute();

                header('Location: mypage.php');
                exit;
            }
        } catch (PDOException $e) {
            $errors['db'] = 'データベースエラーが発生しました。';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>サインアップ</title>
</head>
<body>
    <h1>サインアップ</h1>
    <?php if (isset($errors['sign_up'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errors['sign_up']); ?></p>
    <?php endif; ?>
    <?php if (isset($errors['db'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errors['db']); ?></p>
    <?php endif; ?>
    <?php if (isset($errors['duplicate'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errors['duplicate']); ?></p>
    <?php endif; ?>
    <a href="sign_in.php">サインイン</a>はこちら。
    <hr />
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <table>
            <tr>
                <td>
                    <label for="id">ユーザーID:</label>
                </td>
                <td>
                    <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" required pattern="^[a-zA-Z0-9_\-]{8,36}$">
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
                    <input type="password" name="password" value="" required />
                </td>
                <td>
                    <?php if (isset($errors['password'])): ?>
                        <p style="color: red;"><?php echo htmlspecialchars($errors['password']); ?></p>
                    <?php endif; ?>
                </td>
                </tr>
            <tr>
                <td>
                    <label for="name">名前:</label>
                </td>
                <td>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required />
                </td>
                <td>
                    <?php if (isset($errors['name'])): ?>
                        <p style="color: red;"><?php echo htmlspecialchars($errors['name']); ?></p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="email">メールアドレス:</label>
                </td>
                <td>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required />
                </td>
                <td>
                    <?php if (isset($errors['email'])): ?>
                        <p style="color: red;"><?php echo htmlspecialchars($errors['email']); ?></p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="birthday">生年月日:</label>
                </td>
                <td>
                    <input type="date" name="birthday" value="<?php echo htmlspecialchars($birthday); ?>" required />
                </td>
                <td>
                    <?php if (isset($errors['birthday'])): ?>
                        <p style="color: red;"><?php echo htmlspecialchars($errors['birthday']); ?></p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="comment">コメント:</label>
                </td>
                <td>
                    <textarea name="comment"><?php echo htmlspecialchars($comment); ?></textarea>
                </td>
                <td>
                    <?php if (isset($errors['comment'])): ?>
                        <p style="color: red;"><?php echo htmlspecialchars($errors['comment']); ?></p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <input type="submit" value="サインアップ" />
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
