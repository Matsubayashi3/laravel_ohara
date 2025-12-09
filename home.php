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
</style>

<body>
    <div class="container">
        <div class="eye-g">
            <div class="eye"></div>
            <div class="eye"></div>
        </div>
        <a href="login-input.php"><button class="mouse">ログイン</button></a>
        <a href="register-input.php"><button class="signup">新規登録</button></a>
    </div>
</body>

<!-- フッターの読み込み -->
<?php include 'footer.php' ?>