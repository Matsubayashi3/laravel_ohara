<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- DB接続ファイルの読み込み -->
<?php include 'dbconect.php' ?>

<!-- 個別ブロック -->
<?php
// $id = $_SESSION['user_data']['user_id'];
$id = 4;
$python_executable = 'python';
$python_script = __DIR__ . '/recipe.py';

$command = escapeshellcmd($python_executable) . ' ' .
    escapeshellarg($python_script) . ' ' .
    escapeshellarg($id) . ' ' .

    exec($command, $output);
echo var_dump($output);
?>

<!-- フッターの読み込み -->
<?php include 'footer.php' ?>