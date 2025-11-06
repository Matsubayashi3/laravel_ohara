<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>


<!-- ページ -->

<meta name=”viewport” content=”width=device-width,initial-scale=1.0″>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

<style>
    body {
        background-color: #FCC800;
    }

    .eye {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: black;
        position: absolute;
        top: 320px;
        left: 15%;
    }

    .eye2 {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: black;
        position: absolute;
        top: 320px;
        left: 75%;
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
</style>

<div class="eye"></div>
<div class="eye2"></div>
<div class="container">
    <a href="login-input.php"><button class="mouse">ログイン</button></a>
    <a href="login-input.php"><button class="signup">新規登録</button></a>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>

</html>

<!-- フッターの読み込み -->
<?php include 'footer.php' ?>