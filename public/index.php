<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>サンプルPHPインデックスページ</title>
</head>
<body>
  <h1>サンプルPHPインデックスページへようこそ</h1>

  <?php
  // 現在の日時を表示
  $now = new DateTime();
  echo "<p>現在の日時: " . $now->format('Y-m-d H:i:s') . "</p>";

  // PHPのバージョンを表示
  echo "<p>PHP バージョン: " . phpversion() . "</p>";

  // サーバー情報を表示
  echo "<p>サーバー名: " . $_SERVER['SERVER_NAME'] . "</p>";

  // 簡単な計算
  $a = 10;
  $b = 5;
  echo "<p>計算例: {$a} + {$b} = " . ($a + $b) . "</p>";
  ?>

  <p>これはLAMP環境で動作するシンプルなPHPページです。</p>
</body>
</html>
