<?php

// 例外(Exception)(エラー)処理
try {
    // エラーが起きるかもしれない処理
    $pdo = new PDO("mysql:host=172.16.73.6;dbname=01青木天空;charset=utf8", "staff", "");
} catch (PDOException $e) {
    // エラーが起きた時の処理
    echo 'エラー：' . $e->getMessage();
    exit;
}
?>
<!-- データベース用 -->