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

    #camera-feed {
        width: 100%;
        max-width: 500px;
        height: auto;
        display: block;
        margin-bottom: 20px;
    }

    /* シャッターボタンを丸くして中央配置 */
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
    <video id="camera-feed" autoplay playsinline></video>

    <button id="capture-button"></button>

    <form id="file-select-form" action="add-input.php" method='post' enctype="multipart/form-data">
        <img id="preview" style="display:none; max-width:300px;">
        <input type="file" accept="image/*" onchange="showPreview(this)" name="file">
    </form>

    <canvas id="camera-canvas" style="display:none;"></canvas>

    <img id="captured-photo" alt="撮影した写真">

    <div id="post-capture-controls" style="display:none;">
        <button id="download-button">画像をダウンロード</button>
        <button id="retake-button">写真を取り直す</button>
    </div>
</body>

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

    const videoElement = document.getElementById('camera-feed');
    const captureButton = document.getElementById('capture-button');
    const canvasElement = document.getElementById('camera-canvas');
    const photoElement = document.getElementById('captured-photo');
    const context = canvasElement.getContext('2d');

    // ダウンロードボタンの要素を取得
    const postCaptureControls = document.getElementById('post-capture-controls');
    const downloadButton = document.getElementById('download-button');
    // 取り直しボタンの要素を取得
    const retakeButton = document.getElementById('retake-button');

    let currentStream = null;

    // 1. ストリームを停止する
    function stopCamera() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
        }
    }

    // 2. カメラを起動する
    async function startCamera(facingMode) {
        // カメラフィードを表示に戻す（再起動に備えて）
        videoElement.style.display = 'block';
        photoElement.style.display = 'none'; // 撮影画像を非表示にする
        captureButton.style.display = 'flex'; // シャッターボタンを再表示
        // 撮影後コントロールを非表示に戻す
        postCaptureControls.style.display = 'none';

        // ファイル選択フォームを再表示する
        document.getElementById('file-select-form').style.display = 'block';

        stopCamera();
        const constraints = {
            video: {
                facingMode: facingMode
            }
        };
        try {
            const stream = await navigator.mediaDevices.getUserMedia(constraints);
            currentStream = stream;
            videoElement.srcObject = stream;
            videoElement.play();
        } catch (err) {
            console.error('カメラ起動エラー: ', err);
            alert('カメラのアクセスが拒否されました。');
        }
    }

    // ダウンロード処理を実行する関数
    function downloadPhoto() {
        // <a>タグを動的に作成
        const a = document.createElement('a');
        // photoElement.src (Base64データURL) をダウンロード対象に設定
        a.href = photoElement.src;
        // ファイル名を指定
        a.download = 'captured_photo_' + new Date().getTime() + '.png';
        // ダウンロードを実行
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    // 4. シャッター機能
    captureButton.addEventListener('click', () => {
        // (1) 撮影処理
        canvasElement.width = videoElement.videoWidth;
        canvasElement.height = videoElement.videoHeight;
        context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
        const imageDataURL = canvasElement.toDataURL('image/png');

        // (2) カメラの停止と非表示
        stopCamera();
        videoElement.style.display = 'none';

        // (3) シャッターボタンを非表示にする
        captureButton.style.display = 'none';

        // ファイル選択フォームを非表示にする
        document.getElementById('file-select-form').style.display = 'none';

        // (4) 撮影した画像を代わりに表示
        photoElement.src = imageDataURL;
        photoElement.style.display = 'block';

        // 撮影後コントロールを表示
        postCaptureControls.style.display = 'block';
        // クリックイベントをリセットして、新しいダウンロード処理を確実に追加
        downloadButton.onclick = downloadPhoto;

        // 取り直しボタンにイベントを紐づける
        retakeButton.onclick = () => {
            // カメラを再起動
            startCamera('environment');
        };
    });

    // 5. 初期化
    startCamera('environment');
</script>


<!--フッターの読み込み-->
<?php include 'footer.php' ?>