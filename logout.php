<?php
session_start();

// セッションを破棄
session_destroy();

// ホーム画面にリダイレクト
header('Location: home.php');
exit();
?>