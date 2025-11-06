<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- DB接続ファイルの読み込み -->
<?php include 'dbconect.php' ?>

<!-- ページ -->
<link rel="stylesheet" href="style\login.css">
<div class="container">
    <img class="icon" src="image/くちぱっち背景透明.png" alt="アイコン画像">
    <div class="login-form">
        <h1>ログイン画面</h1>
        <div class="instructions">
            会員名とパスワードを入力してログインしてください。
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

            </form>
            <div class="register-link">
                <a href="register-input.php">新規登録</a>
            </div>
        </div>
    </div>
</div>
<!-- フッターの読み込み -->
<?php include 'footer.php' ?>