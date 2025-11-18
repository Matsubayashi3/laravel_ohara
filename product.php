<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- メニューの読み込み -->

<!-- DB接続ファイルの読み込み -->
<?php include 'dbconect.php' ?>


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
    body div {
        background-color: #FCC800;
    }

    .tab-3 {
        display: flex;
        flex-wrap: wrap;
    }

    .tab-3>label {
        flex: 1 1;
        order: -1;
        min-width: 70px;
        padding: .7em 1em .5em;
        background-color: #f2f2f2;
        color: #999;
        font-weight: 600;
        font-size: .9em;
        text-align: center;
        cursor: pointer;
    }

    .tab-3>label:hover {
        opacity: .8;
    }

    .tab-c {
        display: none;
    }

    .tab-3>div {
        display: none;
        width: 100%;
        /* padding: 1.5em 1em; */
        background-color: #fff;
    }

    .tab-3 label:has(:checked) {
        border-bottom: 4px solid #2589d0;
        color: #2589d0;
    }

    .tab-3 label:has(:checked)+div {
        display: block;
    }

    img {
        width: 8rem;
        height: auto;
    }

    .yasai-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .item {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 20%;
    }

    /* ボタン */
    /* .qty {
        background: #f1ede9;
        padding: 20px 10px;
        border-radius: 10px;
        display: flex;
        width: fit-content;
        margin: 60px auto;
    } */

    #down,
    #up {
        font-size: 25px;
        padding: 0 14px;
        cursor: pointer;
        user-select: none;
    }

    #textBox {
        border: none;
        background: none;
        font-size: 18px;
        text-align: center;
        width: 70px;
    }

    /* [input type="number"]のデフォルトの矢印を消す */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        -moz-appearance: textfield;
    }

    .suggestion {
        margin-top: 100px;
        color: white;
        padding: 8px 16px;
        background-color: #E97132;
    }

    .huton {
        text-align: center;
    }

    a {
        text-decoration: none;
    }

    /* タブレット表示 (768px以下) */
    @media (max-width: 1260px) {
        .item {
            width: 45%;
            /* 2列表示 */
        }
    }

    /* スマホ表示 (480px以下) */
    @media (max-width: 580px) {
        .item {
            width: 30%;
        }

        .yasai-container {
            gap: 10px;
        }

        .item img {
            width: 5rem;
            /* 画像を小さくする */
        }

        /* ボタンと入力欄の縮小 */
        .down,
        .up {
            font-size: 18px;
            /* ボタンの文字サイズを小さく */
            padding: 0 8px;
            /* パディングを小さく */
        }

        .textBox {
            font-size: 14px;
            /* 入力欄の文字サイズを小さく */
            width: 40px;
            /* 入力欄の幅を狭く */
        }

        .btn-group {
            transform: scale(0.8);
            /* 全体を少し縮小 */
            margin-top: 5px;
        }

        .yasai-container {
            gap: 15px;
        }
    }
</style>

<body>
    <div class="tab-3">
        <!-- 野菜タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3" checked>
            野菜
        </label>

        <div>
            <div class="yasai-container">
                <?php
                //　ここにDBから野菜データを取得して表示するコードを追加
                ?>

                <!-- 数量操作ボタン -->
                <?php
                for ($num = 0; $num < 10; $num++) {
                ?>
                    <div class="item">
                        <img src="image/<?= $test_list2[$num] ?>" alt="<?= $test_list[$num] ?>">
                        <?php echo $test_list[$num] ?>
                        <div class="btn-group" role="group" aria-label="数量操作">
                            <button type="button" class="btn btn-primary down">-</button>
                            <input name="<?= $test_list[$num] ?>" type="number" class="textBox btn" value="0">
                            <button type="button" class="btn btn-primary up">+</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>


        <!-- 肉タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            肉
        </label>

        <div>
            ぜひお好みの色にアレンジしてみてください。
        </div>


        <!-- 魚タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            魚
        </label>

        <div>
            もちろんレスポンシブ対応で、タブの追加にも対応しています。
        </div>


        <!-- 主食・粉タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            主食
        </label>

        <div>
            もちろんレスポンシブ対応で、タブの追加にも対応しています。
        </div>


        <!-- 調味料タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            調味料
        </label>

        <div>
            もちろんレスポンシブ対応で、タブの追加にも対応しています。
        </div>


        <!-- スパイスタグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            スパイス
        </label>

        <div>
            もちろんレスポンシブ対応で、タブの追加にも対応しています。
        </div>
    </div>

    <div class="huton">
        <a href="suggestion.php"><button class="suggestion ">レシピ検索</button></a>
    </div>

</body>

<script>
    document.querySelectorAll('.item').forEach(item => {
        const down = item.querySelector('.down');
        const up = item.querySelector('.up');
        const box = item.querySelector('.textBox');

        // 初期値設定
        let num = parseInt(box.value) || 0;
        box.value = num;

        down.addEventListener('click', () => {
            if (num > 0) {
                num--;
                box.value = num;
            }
        });

        up.addEventListener('click', () => {
            num++;
            box.value = num;
        });
    });
</script>


<!-- フッターの読み込み -->
<?php include 'footer.php' ?>