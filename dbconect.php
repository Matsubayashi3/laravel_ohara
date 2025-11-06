<?php

// 例外(Exception)(エラー)処理
try {
    // エラーが起きるかもしれない処理
    $pdo = new PDO(
        "mysql:host=localhost;dbname=cookingai;charset=utf8",
        "root",
        ""
    );
    echo '接続成功';
} catch (PDOException $e) {
    // エラーが起きた時の処理
    echo '失敗：' . $e->getMessage();
    exit;
}
?>
<!-- データベース用 -->