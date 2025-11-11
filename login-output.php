<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- DB接続ファイルの読み込み -->
<?php include 'dbconect.php' ?>

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

//デバック
echo var_dump($user);

//認証ブロック
if ($user !== false && $_POST['password'] == $user['password']) {
    // echo 'ログイン成功！';
    // $_SESSIONの['customer']キーにデータを格納 *二次元連想配列
    $_SESSION['users_data'] = [
        'user_id' => $user['user_id'],
        'user_name' => $user['user_name'],
    ];
    // ""で文字列を表示するときに{変数}で変数を直接埋め込める echoの必要なし
    //  デバッグ
    $message = 'ログイン成功';
    // echo var_dump($_session);
} else {
    $message = 'ユーザー名かパスワードが間違っています。';
}

?>

<!-- ページ -->
<link rel="stylesheet" href="style\login.css">
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