<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- DB接続ファイルの読み込み -->
<?php include 'dbconect.php' ?>

<!-- 個別ブロック -->

<style>
    .modoru button {
        display: block;
        margin: 20px auto 0;
        background-color: #E97132;
        margin-top: 20px;
        margin-left: 30px;
    }
</style>
<?php
$id = $_SESSION['users_data']['user_id'];
var_dump($_FILES);
$img_name = $_FILES['file']['name'];
$python_executable = 'python';
$python_script = __DIR__ . '/gemini.py';

$command = escapeshellcmd($python_executable) . ' ' .
    escapeshellarg($python_script) . ' ' .
    escapeshellarg($id) . ' ' .

    // ファイル名をリネーム（タイムスタンプ + ユーザーID + 拡張子）
    $new_img_name = 'add_' . $id . '.jpg';  // 例: add_1.jpg

//画像を保存（リネーム後のファイル名で保存）
move_uploaded_file($_FILES['file']['tmp_name'], 'image/freeze/' . $new_img_name);
exec($command, $output);
print("<br>");
var_dump($output);
// 2. JSONデコード（PHP配列に変換）
$data = json_decode($output[0], true);
// //SQL準備
// $sql = $pdo->prepare('SELECT food_id FROM food_data where food_name :food_name ');
// //値を紐づけ
// $sql->bindValue(':food_name', $output, PDO::PARAM_STR);
// //実行
// $sql->execute();

// 3. エラーチェックと処理
if (is_array($data)) {
    // セッションに検出された食材データを保存
    $_SESSION['detected_foods'] = $data;

    // foodcheck.phpへリダイレクト
    header('Location: foodcheck.php');
    exit;
} else {
    // echo "❌ JSONデコード失敗: " . json_last_error_msg();
    echo "読み込み失敗しました。もう一度撮影してください。"; ?>
    <!-- 戻るボタン -->
    <div class=modoru>
        <a href="camera-input.php"><button>戻る</button></a>
    </div>
<?php
}
?>