<?php

function validate_user_params($id, $name, $email, $birthday, $comment, $password) {
    $errors = [];

    if (empty($id)) {
        $errors['id'] = $errors['id'] ?? 'IDは必須です。';
    }
    if (strlen($id) < 8) {
        $errors['id'] = $errors['id'] ?? 'IDは8文字以上である必要があります。';
    }
    if (!preg_match('/^[a-zA-Z0-9_\-]+$/', $id)) {
        $errors['id'] = $errors['id'] ?? 'IDは英数字、アンダースコア、ハイフンのみ使用可能です。';
    }

    if (empty($name)) {
        $errors['name'] = $errors['name'] ?? '名前は必須です。';
    }

    if (empty($email)) {
        $errors['email'] = $errors['email'] ?? 'メールアドレスは必須です。';
    }
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        $errors['email'] = $errors['email'] ?? 'メールアドレスの形式が正しくありません。';
    }

    if (empty($birthday)) {
        $errors['birthday'] = $errors['birthday'] ?? '誕生日は必須です。';
    }

    if (empty($password)) {
        $errors['password'] = $errors['password'] ?? 'パスワードは必須です。';
    }
    if (strlen($password) < 8) {
        $errors['password'] = $errors['password'] ?? 'パスワードは8文字以上である必要があります。';
    }

    return $errors;
}

?>
