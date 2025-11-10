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
<!-- ログアウト完了メッセージ -->
<p>ログアウトしました。</p>
<!-- フッターの読み込み -->
<?php include 'footer.php' ?>