<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>

<form action="camera-output.php" method='post' enctype="multipart/form-data">
    <input type="file" accept="image/*" onchange="showPreview(this)" name="file">
    <img id="preview" style="display:none; max-width:300px;">
    </p>
    <p><input type='submit' value='カートに追加'></p>
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

<!-- フッターの読み込み -->
<?php include 'footer.php' ?>