<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>クッキングAI</title>
    <link rel="icon" href="image\icon\くちぱっち.png">
    <!-- Bootstrap -->
    <link href=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>

    <!-- サニタイズ関数h -->
    <?php
    function h($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
    }
    ?>

    <!-- 共通デバッグゾーン -->
    <?php
    // echo '[デバッグゾーン]';
    // echo '■$_POST';
    // echo '<pre>';
    // echo var_dump($_POST);
    // echo '</pre><br>';

    // // $_SESSION
    // echo '■$_SESSION';
    // echo '<pre>';
    // echo var_dump($_SESSION);
    // echo '</pre><br>';

    // // SESSION_ID
    // echo '■セッションID<br>';
    // echo session_id();
    ?>