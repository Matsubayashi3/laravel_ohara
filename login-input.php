<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>

<!-- ページ -->
<link rel="stylesheet" href="style\login.css">
<div class="container">
    <img class="icon" src="image/くちぱっち背景透明.png" alt="アイコン画像">
    <div class="login-form">
        <h1>ログイン</h1>

        <form action="login-output.php" method="post">
            <div class="form-group">
                <label for="username">会員名</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" required>
                <small>※半角英数字記号のみ</small>
            </div>

            <button type="submit" class="login-button">続ける</button>

            <div class="register-link">
                <a href="register.php">新規登録</a>
            </div>
        </form>
    </div>
</div>