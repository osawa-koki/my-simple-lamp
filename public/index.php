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
  $now = new DateTime();
  echo "<p>現在の日時: " . $now->format('Y-m-d H:i:s') . "</p>";
  echo "<p>PHP バージョン: " . phpversion() . "</p>";
  echo "<p>サーバー名: " . $_SERVER['SERVER_NAME'] . "</p>";
  $a = 10;
  $b = 5;
  echo "<p>計算例: {$a} + {$b} = " . ($a + $b) . "</p>";
  ?>

  <p>これはLAMP環境で動作するシンプルなPHPページです。</p>
</body>
</html>
