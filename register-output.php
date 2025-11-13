<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- DB接続ファイルの読み込み -->
<?php include 'dbconect.php' ?>

<!-- 個別ブロック -->
<?php
// csrfチェック

// パスワードの暗号化（ハッシュ化）
$hashpass = password_hash($_POST['password'], PASSWORD_DEFAULT);
//変数の準備
$name = $_POST['user_name'];
$password = $_POST['password'];

// ログイン名の重複チェックブロック
// 入力されたログイン名の存在確認 ⇒DBを検索して結果が空であればまだ使われていないログイン名
if (isset($_SESSION['users_data'])) { //ログインしていたら（更新だったら）
    // SQL準備
    $sql = $pdo->prepare('SELECT * FROM users_data WHERE user_id!=:user_id AND user_name = :user_name'); //idが異なり、ログイン名が同じデータ⇒既に使われているデータ
    // 値を紐づけ
    $sql->bindValue(':user_id', $_SESSION['users_data']['user_id'], PDO::PARAM_INT);
    $sql->bindValue(':user_name', $name, PDO::PARAM_STR);
    // 実行
    $sql->execute();
} else { //ログインしていなかったら（登録だったら）
    // SQL準備
    $sql = $pdo->prepare('SELECT * FROM users_data WHERE user_name = :name');
    // 値を紐づけ
    $sql->bindValue(':name', $name, PDO::PARAM_STR);
    // 実行
    $sql->execute();
}

if (empty($sql->fetchAll())) { //fetchのみだと１件取得、fetchAll全ての結果を取得 ⇒空だったらまだ使われていないログイン名
    //ユーザー情報更新ブロック
    if (isset($_SESSION['users_data'])) { //ログイン判定
        // SQL準備
        $sql = $pdo->prepare('UPDATE users_data SET user_name=:name,password=:password WHERE user_id=:id');
        // 値を紐づけ
        $sql->bindValue(':name', $name, PDO::PARAM_STR);
        $sql->bindValue(':password', $password, PDO::PARAM_INT);
        $sql->bindValue(':id', $_SESSION['users_data']['user_id'], PDO::PARAM_INT);
        // 実行
        $sql->execute();

        // セッション情報の更新
        $_SESSION['users_data'] = [
            'name' => $name,
            'password' => $password,
            'id' => $_SESSION['users_data']['user_id'],
        ];

        $message = 'お客様情報を更新しました';
    } else {
        // ユーザー登録処理
        // 2.SQLの準備
        $sql = 'INSERT INTO users_data values(null,:user_name,:password,null,null)';
        // 3.実行の準備 プリペアードステートメント(stmt)
        $stmt = $pdo->prepare($sql);
        // 3.5 プレースホルダーに値を紐づけ
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':user_name', $name, PDO::PARAM_STR);
        // 4.実行
        $stmt->execute();
        $message = 'お客様情報を登録しました。';
    }
} else { //$sqlが空でない＝ログイン名が既に使われている時
    $message = 'ログイン名が既に使われています。別のログイン名を使用してください';
}

?>

<!-- ページ -->
<link rel="stylesheet" href="style\login.css">
<div class="container">
    <img class="icon" src="image/くちぱっち背景透明.png" alt="アイコン画像">
    <div class="login-form">
        <h1><?php echo $message; ?></h1>
        <?php if ($message === 'お客様情報を登録しました。') : ?>
            <form action="login-input.php" method="post">
                <button type="submit" class="login-button">ログイン画面へ</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- フッターの読み込み -->
<?php include 'footer.php' ?>