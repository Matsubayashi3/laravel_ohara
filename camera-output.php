<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- DB接続ファイルの読み込み -->
<?php include 'dbconect.php' ?>

<!-- 個別ブロック -->

<?php


if (is_uploaded_file($_FILES["file"]["tmp_name"]) == true) {
    $filepass = "image/" . basename($id . ".jpg"); //MAXでうけっとった番号+1の名前に変更
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $filepass) == true) {
        echo "ファイルのアップロードに成功しました。";
        echo "<img src=" . $filepass . ">";
    } else {
        echo "ファイルのアップロードに失敗しました。再送してください";
    }
}

?>