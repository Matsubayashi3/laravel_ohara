<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>


<!-- ページ -->

<style>
    html,
    body {
        overflow: hidden;
    }

    body {
        background-color: #FCC800;
    }

    .eye-g {
        display: grid;
        grid-auto-flow: column;
    }

    .eye {
        width: 40px;
        height: 40px;
        margin: 40px 100px;
        border-radius: 50%;
        background: black;
    }

    .container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .mouse {
        width: 200px;
        height: 50px;
        background: #DD6E35;
        border-radius: 60px;
        cursor: pointer;
        margin: 10px 0;
        border: none;
        color: white;
        font-weight: bold;
    }

    .signup {
        width: 200px;
        height: 50px;
        background: #DD6E35;
        border-radius: 60px;
        cursor: pointer;
        margin: 10px 0;
        border: none;
        color: white;
        font-weight: bold;
    }

    .logout-button {
        display: block;
        margin: 0px auto 0px;
        width: 300px;
        padding: 10px;
        background-color: #DD6E35;
        color: white;
        border: none;
    }

    a {
        text-decoration: none;
    }
</style>

<div class="container">
    <div class="eye-g">
        <div class="eye"></div>
        <div class="eye"></div>
    </div>
    <a href="camera-input.php"><button class="mouse">在庫追加</button></a>
    <a href="product.php"><button class="signup">在庫確認</button></a>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>

</html>

<!-- フッターの読み込み -->
<?php include 'footer.php' ?>