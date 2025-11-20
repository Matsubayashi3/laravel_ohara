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
    escapeshellarg($id);

exec($command, $output);
$json = str_replace('][', ',', $output[0]);
$data = json_decode($json, true);
var_dump($data);
?>

<style>
    .modoru button {
        background-color: #E97132;
        margin-top: 20px;
        margin-left: 30px;
    }

    /* .navbar内の.container-fluidをflexコンテナにし、子要素を中央に配置 */
    .navbar .container-fluid {
        display: flex;
        justify-content: center;
        /* 水平方向の中央寄せ */
    }

    .navbar .btn {
        background-color: #E97132;
        border-color: #E97132;
        /* ボタンのパディングを調整して、画像が収まるようにする */
        padding: 0.375rem 0.75rem;
        /* Bootstrapのデフォルト値に近い値 */
    }

    /* 画像サイズを小さく、かつボタンに収まるように調整 */
    .btn img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        max-width: 30px;
        /* 例として最大幅を20pxに設定 */
        max-height: 30px;
        /* 例として最大高さを20pxに設定 */
    }

    /* 画像を横並びにするためのコンテナスタイル */
    .image-container {
        display: flex;
        /* Flexboxを適用 */
        flex-wrap: wrap;
        /* 子要素を折り返す */
        justify-content: center;
        /* コンテナ全体を中央に配置 */
        margin-top: 20px;
        /* ナビゲーションバーとの間に余白を追加 */
        max-width: 640px;
        /* 2列の画像が収まるように最大幅を設定（例: 300px * 2 + マージン） */
        margin-left: auto;
        /* 中央寄せ */
        margin-right: auto;
        /* 中央寄せ */
    }

    /* .image-container内の各画像アイテムにスタイルを適用 */
    .image-item {
        /* 2列にするため、幅を約50%に設定し、マージンを考慮して少し小さくする */
        width: calc(50% - 20px);
        /* 50%から左右のマージン10px*2を引く */
        margin: 10px;
        /* アイテムの上下左右にスペースを追加 */
        text-align: center;
        /* 画像とキャプションを中央寄せ */
        box-sizing: border-box;
    }

    /* .image-item内の画像にスタイルを適用 */
    .image-item img {
        width: 100%;
        /* 親要素の幅いっぱいに広げる */
        height: auto;
        display: block;
        /* 画像をブロック要素にして、キャプションとの間にスペースを確保 */
    }

    /* キャプションのスタイル */
    .caption {
        margin-top: 5px;
        font-size: 14px;
        color: #333;
    }
</style>

<body>
    <!-- 戻るボタン -->
    <div class=modoru>
        <a href="product.php"><button>冷蔵庫に戻る</button></a>
    </div>
    <!-- 検索バー -->
    <nav class="navbar">
        <div class="container-fluid">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="検索" aria-label="Search">
                <button class="btn" type="submit"><img src="image\musimegane.png" alt="検索"></button>
            </form>
        </div>
    </nav>

    <!-- レシピ -->
    <div class="image-container">
        <div class="image-item">
            <img src="image/yasai.png" alt="レタス1">
            <p class="caption">レタス</p>
        </div>
        <div class="image-item">
            <img src="image/yasai.png" alt="レタス2">
            <p class="caption">レタス</p>
        </div>
        <div class="image-item">
            <img src="image/yasai.png" alt="レタス3">
            <p class="caption">レタス</p>
        </div>
        <div class="image-item">
            <img src="image/yasai.png" alt="レタス4">
            <p class="caption">レタス</p>
        </div>
    </div>

    <!-- フッターの読み込み -->
    <?php include 'footer.php' ?>