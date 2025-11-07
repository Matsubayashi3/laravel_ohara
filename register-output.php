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
        <h1>登録が完了しました。</h1>

        <form action="login-output.php" method="post">
            <div class="form-group">
                <label for="username">会員名</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" requireed>
            </div>

            <button type="submit" class="login-button"></button>
        </form>
    </div>
</div>