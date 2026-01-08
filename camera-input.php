<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- 認証チェック機能の読み込み -->
<?php include 'auth_check.php' ?>

<?php
// ログインチェック
requireLogin();
?>

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
        border-radius: 8px;
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
        color: white;
        border: none;
        padding: 6px 12px;
        margin-top: 20px;
        margin-left: 30px;
        margin-bottom: 20px;
        border-radius: 8px;
    }

    .btn:hover {
        color: white;
        background-color: #E97132;
    }

    /* ローディング画面 */
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #FCC800;
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .loading-content {
        text-align: center;
        background-color: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .spinner {
        border: 6px solid white;
        border-top: 6px solid #E97132;
        border-radius: 50%;
        width: 80px;
        height: 80px;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
        background-color: white;
    }

    .loading-text {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin: 0 0 20px 0;
    }

    .cancel-btn {
        background-color: #ccc;
        color: #333;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
    }

    .cancel-btn:hover {
        background-color: #bbb;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<body>
    <a href="select.php"><button class="btn">戻る</button></a>
    <!-- ファイル選択から画像 -->
    <div class="color">
        <!-- ▼▼▼ onsubmit属性を変更 ▼▼▼ -->
        <form id="file-select-form" action="camera-output.php" method='post' enctype="multipart/form-data" style=" text-align:center;" onsubmit="return showFullScreenLoading()">
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

        function showFullScreenLoading() {
            // ファイルが選択されていない場合は処理を中断
            const fileInput = document.querySelector('input[type="file"]');
            if (fileInput.files.length === 0) {
                alert('ファイルを選択してください。');
                return false; // フォームの送信を中止
            }

            // ローディング表示を見せる
            document.querySelector('.loading-overlay').style.display = 'flex';

            // アップロードボタンを無効化
            const uploadButton = document.querySelector('.upload');
            uploadButton.disabled = true;

            return true; // フォームの送信を続行
        }

        // DOMが読み込まれた後にイベントリスナーを設定
        document.addEventListener('DOMContentLoaded', function() {
            let formSubmitted = false;
            
            // フォーム送信時の処理
            document.getElementById('file-select-form').addEventListener('submit', function() {
                formSubmitted = true;
            });
            
            // キャンセルボタンの処理
            document.getElementById('cancel-btn').addEventListener('click', function() {
                if (formSubmitted) {
                    // フォームが送信済みの場合はページをリロードして処理を中断
                    window.location.reload();
                } else {
                    // フォームがまだ送信されていない場合はローディングを非表示
                    document.querySelector('.loading-overlay').style.display = 'none';
                    const uploadButton = document.querySelector('.upload');
                    uploadButton.disabled = false;
                }
            });
        });
    </script>

    <!--フッターの読み込み-->
    <?php include 'footer.php' ?>

    <!-- ローディング画面 -->
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-content">
            <div class="spinner"></div>
            <p class="loading-text">食材を認識中...</p>
            <button class="cancel-btn" id="cancel-btn">キャンセル</button>
        </div>
    </div>

</body>