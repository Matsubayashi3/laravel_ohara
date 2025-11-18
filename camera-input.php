<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>

<!-- 個別ブロック-->
<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
    }

    /* ここからカメラ */
    #camera-feed {
        width: 100%;
        max-width: 500px;
        height: auto;
        display: block;
        margin-bottom: 20px;
    }

    #capture-button {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: gray;
        border: 10px solid white;
        cursor: pointer;
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #capture-button::after {
        content: '';
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: white;
    }

    #captured-photo {
        margin-top: 20px;
        display: none;
        max-width: 100%;
    }

    /* 追加: 撮影後コントロールのレスポンシブ対応 */
    #post-capture-controls {
        display: flex;
        justify-content: center;
        /* ボタンを中央に寄せる */
        gap: 10px;
        /* ボタン間のスペース */
        margin-top: 10px;
        flex-wrap: wrap;
        /* 画面幅が狭い場合に折り返す */
    }

    #post-capture-controls button {
        padding: 10px 20px;
        /* 必要に応じてボタンの幅を調整 */
        flex-grow: 1;
        /* 均等に幅を広げる */
        min-width: 150px;
        /* 最小幅を設定して極端に小さくなるのを防ぐ */
    }
</style>

<body>
    <!-- ファイル選択から画像 -->
    <form id="file-select-form" action="camera-output.php" method='post' enctype="multipart/form-data">
        <img id="preview" style="display:none; max-width:300px;">
        <input type="file" accept="image/*" onchange="showPreview(this)" name="file">
        <input type='submit' value='アップロード'>
    </form>

    <script>
        function showPreview(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>


    <!--フッターの読み込み-->
    <?php include 'footer.php' ?>