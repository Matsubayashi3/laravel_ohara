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

        <form action="login.php" method="post">
            <a href="login-input.php"><button type="submit" class="login-button">ログイン画面へ</button></a>
        </form>
    </div>
</div>

