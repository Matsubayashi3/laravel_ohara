<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!--メニューの読み込み -->
<?php include 'menu.php' ?>
<!-- DB接続ファイルの読み込み -->
<?php include 'dbconect.php' ?>

<!-- 個別ブロック -->
<?php
//DBからログイン名と一致するデータの取り出し
//  セッション情報の初期化
unset($_SESSION['customer']);
//SQL準備
$sql = $pdo->prepare('SELECT * FROM customer WHERE login = :login');
//プレースホルダに値を紐づけ
$sql->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
//SQL実行
$sql->execute();
//1件だけデータ取り出し(fetch) FETCH_ASSOCで添字つきの配列を返す。ex.添字[name] ->
$user = $sql->fetch(PDO::FETCH_ASSOC);

//デバック
// echo var_dump($user);

//認証ブロック
if ($user && password_verify($_POST['password'], $user['password'])) {
    // echo 'ログイン成功！';
    // $_SESSIONの['customer']キーにデータを格納 *二次元連想配列
    $_SESSION['customer'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'address' => $user['address'],
        'login' => $user['login']
    ];
    // ""で文字列を表示するときに{変数}で変数を直接埋め込める echoの必要なし
    echo "いらっしゃいませ、{$_SESSION['customer']['name']}様";
    //  デバッグ
    // echo var_dump($_session);
} else {
    echo 'ログイン失敗。。。';
}


?>

<!-- フッターの読み込み -->
<?php include 'footer.php' ?>