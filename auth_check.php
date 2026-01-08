<?php
// ログイン状態をチェックする関数
function isLoggedIn() {
    return isset($_SESSION['users_data']) && !empty($_SESSION['users_data']);
}

// ログインが必要なページでの認証チェック
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login-input.php');
        exit();
    }
}

// ログイン済みユーザーのリダイレクト
function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        header('Location: select.php');
        exit();
    }
}
?>