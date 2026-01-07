<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>

<!-- 個別ブロック-->
<style>
    body {
        background-color: #FCC800;
    }

    body div {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        background-color: #FCC800;
    }

    /* (中略) 他のスタイルは変更なし */

    .file-button::file-selector-button {
        display: inline-block;
        margin-top: 20px;
    }

    .upload {
        display: inline-block;
        margin-top: 30px;
        padding: 8px 16px;
        background-color: #E97132;
        color: white;
        border: none;
    }

    input[type="file"] {
        display: block;
        margin: 0 auto 20px auto;
    }

    .color {
        background-color: white;
        margin: 20px;
    }

    .btn {
        background-color: #E97132;
        margin-top: 20px;
        margin-left: 30px;
        color: white;
        border-radius: 0;
    }

    /* ▼▼▼ ここから全画面ローディングのスタイルを追加 ▼▼▼ */
    #loading-overlay {
        position: fixed;
        /* 画面全体に固定 */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* 半透明の黒い背景 */
        display: none;
        /* 初期状態では非表示 */
        justify-content: center;
        align-items: center;
        z-index: 9999;
        /* 他の要素より手前に表示 */
        flex-direction: column;
        /* テキストをスピナーの下に配置 */
        color: white;
        font-size: 1.2em;
    }

    .spinner {
        border: 8px solid rgba(255, 255, 255, 0.3);
        /* スピナーの色を白ベースに変更 */
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border-top-color: #FFF;
        /* スピナーの一部分を白くして回転を分かりやすく */
        animation: spin 1s ease infinite;
        margin-bottom: 20px;
        /* テキストとの間隔 */
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* ▲▲▲ ここまで追加 ▲▲▲ */
</style>

<body>
    <a href="select.php"><button class="btn">戻る</button></a>
    <!-- ファイル選択から画像 -->
    <div class="color">
        <!-- ▼▼▼ onsubmit属性を変更 ▼▼▼ -->
        <form id="file-select-form" action="camera-output.php" method='post' enctype="multipart/form-data" style=" text-align:center;" onsubmit="showFullScreenLoading()">
            <img id="preview" style="display:none; max-width:300px;">
            <input type="file" accept="image/*" onchange="showPreview(this)" name="file">
            <input type='submit' class="upload" value='アップロード'>
        </form>
        <!-- ▲▲▲ onsubmit属性を変更 ▲▲▲ -->
    </div>

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

        // ▼▼▼ ここから関数名を変更し、処理を更新 ▼▼▼
        function showFullScreenLoading() {
            // ファイルが選択されていない場合は処理を中断
            const fileInput = document.querySelector('input[type="file"]');
            if (fileInput.files.length === 0) {
                alert('ファイルを選択してください。');
                return false; // フォームの送信を中止
            }

            // ローディング表示を見せる
            document.getElementById('loading-overlay').style.display = 'flex';

            // アップロードボタンを無効化
            const uploadButton = document.querySelector('.upload');
            uploadButton.disabled = true;

            return true; // フォームの送信を続行
        }
        // ▲▲▲ ここまで更新 ▲▲▲
    </script>

    <!--フッターの読み込み-->
    <?php include 'footer.php' ?>

    <!-- ▼▼▼ ここから全画面ローディングのHTMLを追加 (bodyの閉じタグ直前) ▼▼▼ -->

    <!-- ▲▲▲ ここまで追加 ▲▲▲ -->

</body>