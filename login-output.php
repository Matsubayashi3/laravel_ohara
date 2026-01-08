<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- DB接続ファイルの読み込み -->
<?php include 'dbconect.php' ?>
<!-- 認証チェック機能の読み込み -->
<?php include 'auth_check.php' ?>

<!-- 個別ブロック -->
<?php
$name = $_POST['user_name'];
$password = $_POST['password'];

unset($_SESSION['users_data']);
//SQL準備
$sql = $pdo->prepare('SELECT * FROM users_data WHERE user_name = :user_name');
//プレースホルダに値を紐づけ
$sql->bindValue(':user_name', $name, PDO::PARAM_STR);
//SQL実行
$sql->execute();
//1件だけデータ取り出し(fetch) FETCH_ASSOCで添字つきの配列を返す。ex.添字[name] ->
$user = $sql->fetch(PDO::FETCH_ASSOC);

// デバッグ（本番環境では削除）
// echo var_dump($user);
// echo var_dump($_POST);

//認証ブロック
if ($user !== false && $_POST['password'] == $user['password']) {
    // セッションにユーザー情報を保存
    $_SESSION['users_data'] = [
        'user_id' => $user['user_id'],
        'user_name' => $user['user_name'],
        'login_time' => time() // ログイン時刻を記録
    ];
    
    // セッションの有効期限を設定（24時間）
    ini_set('session.gc_maxlifetime', 86400);
    session_set_cookie_params(86400);
    
    $message = 'ログイン成功';
} else {
    $message = 'ユーザー名かパスワードが間違っています。';
}

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
    }

    .login-form {
        background: white;
        width: 100%;
        height: 400px;
        max-width: 600px;
        box-shadow: 0 0 0 10px white;
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
        display: block;
        margin: 20px auto 0;
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

    @media (max-width: 480px) {
        .container {
            padding: 15px;
        }

        .login-form {
            padding: 15px;
            margin: 8px;
            box-shadow: 0 0 0 8px white;
        }

        input,
        .login-button {
            width: 100%;
        }
    }
</style>
<!-- ページ -->
<div class="container">
    <img class="icon" src="image/くちぱっち背景透明.png" alt="アイコン画像">
    <div class="login-form">
        <?php if ($message === 'ログイン成功') : ?>
            <?php header('Location: select.php');
            exit(); ?>
        <?php else: ?>
            <h1><?php echo $message; ?></h1>
            <form action="login-input.php" method="post">
                <button type="submit" class="login-button">ログイン画面へ</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- フッターの読み込み -->
<?php include 'footer.php' ?>