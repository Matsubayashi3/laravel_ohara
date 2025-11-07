<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>

<?
// 変数を初期化
$name = " ";
$password = " ";

//csrf　対策
$token = random_bytes(32);
$csrf_token = bin2hex($token);
// echo $csrf_token;
$_SESSION['csrf'] = $csrf_token;

// ログイン判定＆変数代入
if (isset($_SESSION['users_data'])) { //ログインしている時
    $name = $_SESSION['users_data']['user_name'];
    $password = $_SESSION['users_data']['password'];
}
echo $name;
echo $password;
?>
<!-- ページ -->
<link rel="stylesheet" href="style\login.css">
<div class="container">
    <img class="icon" src="image/くちぱっち背景透明.png" alt="アイコン画像">
    <div class="login-form">
        <h1>新規登録</h1>

        <form action="register-output.php" method="post">
            <div class="form-group">
                <label for="user_name">会員名</label>
                <input type="text" id="user_name" name="user_name" value="<?= $name ?>" required>
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" value="<?= $password ?>" required>
                <small>※半角英数字記号のみ</small>
            </div>

            <button type="submit" class="login-button">登録</button>

            <div class="register-link">
                <a href="login-input.php">ログイン</a>
            </div>
            <input type='hidden' name='csrf' value='<?= $_SESSION['csrf'] ?>'>
        </form>
    </div>
</div>
<!-- フッターの読み込み -->
<?php include 'footer.php' ?>