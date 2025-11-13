<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- DB接続ファイルの読み込み -->
<?php include 'dbconect.php' ?>

<!-- 個別ブロック -->

<?php
$id = $_SESSION['users_data']['user_id'];
var_dump($_FILES);
$img_name = $_FILES['file']['name'];

// ファイル名をリネーム（タイムスタンプ + ユーザーID + 拡張子）
$new_img_name = 'add_' . $id . '.jpg';  // 例: add_1.jpg

//画像を保存（リネーム後のファイル名で保存）
move_uploaded_file($_FILES['file']['tmp_name'], 'image/冷蔵庫/' . $new_img_name);

?>