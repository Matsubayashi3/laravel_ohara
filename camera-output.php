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
exec($command, $output, $return_code);
print("<br>");
echo "<pre>";
echo "Return code: " . $return_code . "<br>";
echo "Output array count: " . count($output) . "<br>";
var_dump($output);
echo "</pre>";

// エラーチェック
if ($return_code !== 0 || empty($output)) {
    echo "<p style='color:red;'>Python実行エラー: コード " . $return_code . "</p>";
    echo "読み込み失敗しました。もう一度撮影してください。";
    exit;
}
// 2. JSONデコード（PHP配列に変換）
if (isset($output[0]) && !empty($output[0])) {
    $json_string = $output[0];
    
    // エラーメッセージが含まれているかチェック
    if (strpos($json_string, '❌') !== false || strpos($json_string, 'error') !== false || strpos($json_string, 'Error') !== false) {
        echo "<p style='color:red;'>APIエラー: " . htmlspecialchars($json_string) . "</p>";
        echo "読み込み失敗しました。もう一度撮影してください。";
        exit;
    }
    
    // 複数行の出力を結合
    $full_output = implode('', $output);
    
    // ```json と ``` を除去
    $full_output = preg_replace('/```json\s*/', '', $full_output);
    $full_output = preg_replace('/```\s*/', '', $full_output);
    $full_output = trim($full_output);
    
    $data = json_decode($full_output, true);
    
    // JSONデコードエラーチェック
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "<p style='color:red;'>JSONパースエラー: " . json_last_error_msg() . "</p>";
        echo "<p>元データ: " . htmlspecialchars($full_output) . "</p>";
        $data = null;
    }
} else {
    $data = null;
}
// //SQL準備
// $sql = $pdo->prepare('SELECT food_id FROM food_data where food_name :food_name ');
// //値を紐づけ
// $sql->bindValue(':food_name', $output, PDO::PARAM_STR);
// //実行
// $sql->execute();

// 3. エラーチェックと処理
if (is_array($data) && !empty($data)) {
    // セッションに検出された食材データを保存
    $_SESSION['detected_foods'] = $data;

    // foodcheck.phpへリダイレクト
    header('Location: foodcheck.php');
    exit;
} else {
    // エラー画面を表示
    ?>
    <style>
        body {
            background-color: #FCC800;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .error-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .error-message {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .retry-btn {
            background-color: #E97132;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        .retry-btn:hover {
            background-color: #D85A1F;
        }
    </style>
    <div class="error-container">
        <p class="error-message">読み取りに失敗しました。</p>
        <a href="camera-input.php"><button class="retry-btn">再度食材を認識する</button></a>
    </div>
    <?php
    exit;
}
?>