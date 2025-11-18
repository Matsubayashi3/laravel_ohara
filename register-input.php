<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>

<?
// 変数を初期化
$name = " ";
$password = " ";


// ログイン判定＆変数代入
if (isset($_SESSION['users_data'])) { //ログインしている時
    $name = $_SESSION['users_data']['user_name'];
    $password = $_SESSION['users_data']['password'];
}
echo $name;
echo $password;
?>

<style>
    body {
        background-color: #FCC800;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        place-content: center;
        flex-direction: column;
        margin-top: 15vh;
        padding: 15px;
    }

    .login-form {
        background: white;
        width: 100%;
        height: 400px;
        max-width: 600px;
        box-shadow: 0 0 0 8px white;
        padding: 15px;
        margin: 8px;
    }

    h1 {
        text-align: center;
        margin-top: 20px;
        margin-bottom: 0px;
        color: #333;
        font-size: 24px;
    }

    .form-group {
        align-items: center;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    input {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 300px;
        padding: 3px;
        border: 1px solid #000;
        font-size: 16px;
    }

    small {
        display: block;
        color: #666;
        margin-top: 5px;
        font-size: 12px;
    }

    .login-button {
        width: 300px;
        padding: 10px;
        background-color: #DD6E35;
        color: white;
        border: none;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px;
    }

    .register-link {
        text-align: center;
        margin-top: 15px;
    }

    .register-link a {
        color: #DD6E35;
        text-decoration: none;
    }

    form {
        margin-top: 40px;
    }

    .icon {
        width: 80px;
        height: auto;
        margin-bottom: 30px;
    }

    input,
    .login-button {
        width: 80%;
    }

    .instructions {
        margin-left: 15%;
    }

    .text {
        text-align: center;
    }

    /* 
    @media (max-width: 1260px) {
        .container{
            
        }
    } */

    /* @media (max-width: 1260px) {

        
    } */
</style>

<!-- ページ -->
<div class="container">
    <img class="icon" src="image/くちぱっち背景透明.png" alt="アイコン画像">
    <div class="login-form">
        <h1>新規登録</h1>

        <form action="register-output.php" method="post">
            <div class="instructions">
                <div class="form-group">
                    <label for="user_name">会員名</label>
                    <input type="text" id="user_name" name="user_name" required>
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password" required>
                    <small>※半角英数字記号のみ</small>
                </div>

                <button type="submit" class="login-button">登録</button>
            </div>
            <div class="register-link">
                <a href="login-input.php">ログイン</a>
            </div>
            <input type='hidden' name='csrf' value='<?= $_SESSION['csrf'] ?>'>
        </form>
    </div>
</div>
<!-- フッターの読み込み -->
<?php include 'footer.php' ?>