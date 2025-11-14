<?php
// call_python_and_get_data.php

// Pythonインタープリタのパス (前回修正した内容を引き継ぎます)
// 環境に合わせて 'python' または '/path/to/your/python.exe' を使用してください。
$python_executable = 'python'; 

// Pythonスクリプトへのパスを絶対パスで指定します。
// __DIR__ は、現在のPHPファイルが存在するディレクトリのパスを返します。
// これにより、PHPファイルと同じディレクトリにあるPythonスクリプトを確実に指定できます。
$python_script = __DIR__ . '/my_python_script.py';

// Pythonスクリプトに渡す引数
$user_name = '桜子';
$user_age = 28;

// コマンド文字列を組み立てます。
// escapeshellarg() を使用して、各引数を個別にエスケープすることが重要です。
$command = escapeshellcmd($python_executable) . ' ' .
           escapeshellarg($python_script) . ' ' .
           escapeshellarg($user_name) . ' ' .
           escapeshellarg($user_age);

// ここで、標準エラー出力もキャプチャするようにコマンドを修正します。
// Pythonスクリプトが見つからない場合や、実行権限がない場合、
// あるいはPythonスクリプト内部でエラーが発生した場合に、
// エラーメッセージが標準エラー出力に出力されることがあります。
// そのメッセージをPHP側で受け取れるようにします。
$command .= ' 2>&1'; // 標準エラー出力を標準出力にリダイレクト

$output = [];      // Pythonスクリプトの出力行が格納されます
$return_var = 0;   // コマンドの終了ステータス（0は成功）

// 外部コマンドを実行し、出力を取得
exec($command, $output, $return_var);

echo "<h2>Pythonスクリプトからのデータ受信</h2>";

if ($return_var === 0) {
    $json_string = implode("\n", $output);
    $data = json_decode($json_string, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        echo "<p>Pythonスクリプトが正常に実行され、JSONデータを受信しました。</p>";
        echo "<h3>受信データ（PHPの連想配列）:</h3>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";

        echo "<h4>受信したデータの利用例:</h4>";
        echo "<p>メッセージ: " . htmlspecialchars($data['message']) . "</p>";
        echo "<p>ユーザー名: " . htmlspecialchars($data['user_name']) . "</p>";
        echo "<p>ユーザー年齢: " . htmlspecialchars($data['user_age']) . "</p>";
        echo "<p>ステータス: " . htmlspecialchars($data['status']) . "</p>";
        echo "<p>計算された誕生日年: " . htmlspecialchars($data['processed_info']['next_birthday_year']) . "</p>";

    } else {
        echo "<p style='color: red;'>エラー: PythonからのJSONデータのデコードに失敗しました。</p>";
        echo "<p>JSONエラー: " . htmlspecialchars(json_last_error_msg()) . "</p>";
        echo "<h3>生のPython出力:</h3><pre>" . htmlspecialchars($json_string) . "</pre>";
    }
} else {
    echo "<p style='color: red;'>エラー: Pythonスクリプトの実行に失敗しました。</p>";
    echo "<p>終了コード: " . htmlspecialchars($return_var) . "</p>";
    echo "<h3>Pythonからの出力（エラー出力を含む可能性あり）:</h3><pre>";
    foreach ($output as $line) {
        echo htmlspecialchars($line) . "\n";
    }
    echo "</pre>";
}

echo "<h3>デバッグ情報:</h3>";
echo "<p>実行コマンド: " . htmlspecialchars($command) . "</p>";

?>