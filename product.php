<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- メニューの読み込み -->

<!-- DB接続ファイルの読み込み -->



<!-- 個別ブロック -->
<!-- 検索ブロック -->
<!-- <form action='product.php' method='post'>
    商品検索
    <input type='text' name='search'>
    <input type='submit' value='検索'>
</form>
<hr> -->

<?php
//検索処理
// if (isset($_POST['search'])) { //検索ワードが入力されていたら
//     //SQL準備
//     $sql = $pdo->prepare('SELECT * FROM product WHERE name LIKE :search');
//     //値を紐づけ
//     $sql->bindValue(':search', '%' . $_POST['search'] . '%', PDO::PARAM_STR);
//     //実行
//     $sql->execute();
// } else { //検索ワードが入力されていなかったら（全件表示・デフォルト表示）
//     //DBから商品データの取り出し
//     $sql = $pdo->query('SELECT * FROM product');
// }
// //表示ブロック
?>

<style>
    /* ボタン */
    body {
        margin: 0;
        width: 100%;
    }

    .container {
        width: 300px;
        margin: 200px auto 0;
    }

    .field {
        display: flex;
    }

    .inputtext {
        color: rgba(43, 32, 32, 0.76);
        font-size: 18px;
        border-left: 0;
        border-right: 0;
        width: 80px;
        line-height: 3rem;
        text-align: center;
        border: 1px solid #D7DBDD;
        padding: 0 10px;
    }

    .button {
        color: rgba(43, 32, 32, 0.76);
        font-size: 18px;
        cursor: pointer;
        padding: 5px 25px;
        background-color: white;
        border: 1px solid #D7DBDD;
        border-radius: 0;
        outline: 0;
    }

    /* ここからタブ */
    .area {
        width: 100%;
        /* height: 60px; */
        max-width: 1200px;
        flex-wrap: nowrap;
        display: flex;
        overflow-x: auto;
    }

    .tab_class {
        width: calc(100%/5);
        height: 50px;
        background-color: darkgrey;
        line-height: 50px;
        font-size: 15px;
        text-align: center;
        display: block;
        float: left;
        order: -1;
        min-width: 120px;
        flex: 0 0 auto;
        margin: 0 2px;
        white-space: nowrap;
    }

    input[name="tab_name"] {
        display: none;
    }

    input:checked+.tab_class {
        background-color: cadetblue;
        color: aliceblue;
    }

    .content_class {
        display: none;
        width: 100%;
    }

    input:checked+.tab_class+.content_class {
        display: block;
    }
</style>

<script>
    // DOM が完全に読み込まれてから要素を取得してイベント登録する
    document.addEventListener('DOMContentLoaded', () => {
        // HTML の id 値を使って以下の DOM 要素を取得
        const downbutton = document.getElementById('down');
        const upbutton = document.getElementById('up');
        const text = document.getElementById('textbox');
        const reset = document.getElementById('reset');

        // 要素が存在するか確認してからイベントを登録（null チェック）
        if (downbutton) {
            downbutton.addEventListener('click', (event) => {
                if (text && Number(text.value) >= 1) {
                    text.value = String(Number(text.value) - 1);
                }
            });
        }

        if (upbutton) {
            upbutton.addEventListener('click', (event) => {
                if (text) {
                    text.value = String(Number(text.value) + 1);
                }
            });
        }

        if (reset) {
            reset.addEventListener('click', (event) => {
                if (text) text.value = '0';
            });
        }
    });
</script>

<!-- 野菜 -->
<div class="area">
    <input type="radio" name="tab_name" id="tab1" checked>
    <label class="tab_class" for="tab1">野菜</label>
    <div class="content_class">
        <div class="container">
            <div class="field">
                <button type="button" class="button" id="down_1">－</button>
                <input type="text" value="0" class="inputtext" id="textbox_1">
                <button type="button" class="button" id="up_1">＋</button>
            </div>
        </div>
    </div>

    <!-- 肉 -->
    <input type="radio" name="tab_name" id="tab2">
    <label class="tab_class" for="tab2">肉</label>
    <div class="content_class">
        <div class="container">
            <div class="field">
                <button type="button" class="button" id="down_2">－</button>
                <input type="text" value="0" class="inputtext" id="textbox_2">
                <button type="button" class="button" id="up_2">＋</button>
            </div>
        </div>
    </div>

    <!-- 魚介 -->
    <input type="radio" name="tab_name" id="tab3">
    <label class="tab_class" for="tab3">魚介</label>
    <div class="content_class">
        <div class="container">
            <div class="field">
                <button type="button" class="button" id="down_3">－</button>
                <input type="text" value="0" class="inputtext" id="textbox_3">
                <button type="button" class="button" id="up_3">＋</button>
            </div>
        </div>
    </div>

    <!-- 主食・粉 -->
    <input type="radio" name="tab_name" id="tab4">
    <label class="tab_class" for="tab4">主食・粉</label>
    <div class="content_class">
        <div class="container">
            <div class="field">
                <button type="button" class="button" id="down_4">－</button>
                <input type="text" value="0" class="inputtext" id="textbox_4">
                <button type="button" class="button" id="up_4">＋</button>
            </div>
        </div>
    </div>

    <!-- 調味料 -->
    <input type="radio" name="tab_name" id="tab5">
    <label class="tab_class" for="tab5">調味料</label>
    <div class="content_class">
        <div class="container">
            <div class="field">
                <button type="button" class="button" id="down_5">－</button>
                <input type="text" value="0" class="inputtext" id="textbox_5">
                <button type="button" class="button" id="up_5">＋</button>
            </div>
        </div>
    </div>

    <!-- スパイス -->
    <input type="radio" name="tab_name" id="tab6">
    <label class="tab_class" for="tab6">スパイス</label>
    <div class="content_class">
        <div class="container">
            <div class="field">
                <button type="button" class="button" id="down_6">－</button>
                <input type="text" value="0" class="inputtext" id="textbox_6">
                <button type="button" class="button" id="up_6">＋</button>
            </div>
        </div>
    </div>

    <!-- 卵・乳・豆 -->
    <input type="radio" name="tab_name" id="tab7">
    <label class="tab_class" for="tab7">卵・乳・豆</label>
    <div class="content_class">
        <div class="container">
            <div class="field">
                <button type="button" class="button" id="down_7">－</button>
                <input type="text" value="0" class="inputtext" id="textbox_7">
                <button type="button" class="button" id="up_7">＋</button>
            </div>
        </div>
    </div>

    <!-- デザート -->
    <input type="radio" name="tab_name" id="tab8">
    <label class="tab_class" for="tab8">デザート</label>
    <div class="content_class">
        <div class="container">
            <div class="field">
                <button type="button" class="button" id="down_8">－</button>
                <input type="text" value="0" class="inputtext" id="textbox_8">
                <button type="button" class="button" id="up_8">＋</button>
            </div>
        </div>
    </div>

    <!-- その他 -->
    <input type="radio" name="tab_name" id="tab9">
    <label class="tab_class" for="tab9">その他</label>
    <div class="content_class">
        <div class="container">
            <div class="field">
                <button type="button" class="button" id="down_9">－</button>
                <input type="text" value="0" class="inputtext" id="textbox_9">
                <button type="button" class="button" id="up_9">＋</button>
            </div>
        </div>
    </div>
</div>

<script src="main.js"></script>

<!-- フッターの読み込み -->
<?php include 'footer.php' ?>