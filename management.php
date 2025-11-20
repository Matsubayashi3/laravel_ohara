<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- DB接続ファイルの読み込み -->
<?php include 'dbconect.php' ?>
<!-- 個別ブロック -->
<?php
$_SESSION = [];
?>

<style>
    body {
        background-color: #FCC007;
    }

    body p {
        text-align: center;
        margin: 20px;
        margin-top: 300px;
    }

    a {
        text-decoration: none;
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
</style>

<body>

    <!-- ログアウト完了メッセージ -->
    <p>ログアウトしました。</p>

    <a href="login-input.php"><button class="login-button">ログイン画面へ</button></a>

</body>
<!-- フッターの読み込み -->
<?php include 'footer.php' ?>