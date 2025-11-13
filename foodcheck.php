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
    body {
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
        padding: 1.5em 1em;
        background-color: #fff;
    }

    .tab-3 label:has(:checked) {
        border-bottom: 4px solid #2589d0;
        color: #2589d0;
    }

    .tab-3 label:has(:checked)+div {
        display: block;
    }

    /* 画像サイズを全体的に縮小 */
    img {
        width: 8rem;
        /* 8remから縮小 */
        height: auto;
    }

    .yasai-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        /* 20pxから縮小 */
        justify-content: center;
    }

    .item {
        /* item全体をflexコンテナにする */
        display: flex;
        flex-direction: row;
        /* 横に並べる */
        align-items: center;
        /* 垂直方向中央揃え */
        justify-content: flex-start;
        /* 左寄せ */
        padding: 8px;
        /* 10pxから縮小 */
        border: 1px solid #eee;
        /* 境界線を追加 */
        margin-bottom: 8px;
        /* 10pxから縮小 */
        width: 100%;
        /* 親要素の幅いっぱいに広げる */
        max-width: 350px;
        /* 400pxから縮小 */
    }

    .item-details {
        display: flex;
        flex-direction: column;
        /* テキストとコントロールを縦に並べる */
        justify-content: center;
        margin-left: 10px;
        /* 15pxから縮小 */
        flex-grow: 1;
        /* 残りのスペースを埋める */
    }

    .item-name {
        font-weight: bold;
        margin-bottom: 3px;
        /* 5pxから縮小 */
        font-size: 1em;
        /* 商品名のフォントサイズを調整 */
    }

    /* 新しいコンテナのスタイル */
    .control-row {
        display: flex;
        align-items: center;
        gap: 5px;
        /* 数値操作とボタンの間のスペース */
        margin-top: 3px;
        /* 数値操作とテキストの間のスペース */
    }

    /* 変更・削除ボタンを縦に並べるためのコンテナ */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 3px;
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

    /* 数値操作ボタンのサイズを縮小 */
    .btn-group button {
        font-size: 1em;
        /* 25pxから縮小 */
        padding: 0 8px;
        /* 0 14pxから縮小 */
        cursor: pointer;
        user-select: none;
    }

    /* 数値入力欄のサイズを縮小 */
    .textBox {
        border: none;
        background: none;
        font-size: 1em;
        /* 18pxから縮小 */
        text-align: center;
        width: 50px;
        background-color: #fff;
        /* 70pxから縮小 */
    }

    /* 変更・削除ボタンのサイズを縮小 */
    .change-btn,
    .delete-btn {
        padding: 0.3em 0.7em;
        /* さらに縮小 */
        font-size: 0.9em;
        /* さらに縮小 */
        width: 100%;
        /* 親要素の幅いっぱいに広げる */

        background-color: #E97132;
        color: white;
    }

    /* [input type="number"]のデフォルトの矢印を消す */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        -moz-appearance: textfield;
    }

    .suggestion {
        margin-top: 50px;
        /* 100pxから縮小 */
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

    .btn-right {
        margin-left: 70px;
    }

    /* タブレット表示 (768px以下) */
    @media (max-width: 1260px) {
        .item {
            width: 45%;
            /* 2列表示 */
        }
    }

    /* スマホ表示 (480px以下) の調整をさらに強化 */
    @media (max-width: 580px) {
        .item {
            width: 95%;
            /* 幅を広げ、中央寄せを維持 */
            max-width: none;
            justify-content: space-between;
            /* 要素間にスペースを空ける */
            padding: 5px;
            margin-bottom: 5px;
        }

        .yasai-container {
            gap: 10px;
        }

        .item img {
            width: 6rem;
            /* 画像をさらに小さく */
        }

        .item-details {
            margin-left: 5px;
        }

        .item-name {
            font-size: 1em;
            margin-top: 10px;
        }

        /* ボタンと入力欄の縮小 */
        .btn-group button {
            font-size: 0.9em;
            padding: 0 5px;
        }

        .textBox {
            font-size: 1em;
            width: 50px;
        }

        .change-btn,
        .delete-btn {
            padding: 0.5em 0.8em;
            /* さらに縮小 */
            font-size: 0.8em;
            /* さらに縮小 */
            margin-left: 20px;
        }

        .btn-group {
            transform: none;
            /* 縮小を解除 */
            margin-top: 0;
        }

        .yasai-container {
            gap: 10px;
        }

        .control-row {
            flex-direction: row;
            /* スマホでも横並びを維持し、スペースを詰める */
            align-items: center;
            gap: 3px;
        }
    }
</style>

<body>
    <h4 style="text-align: center;">追加食材確認</h4>

    <div>
        <div class="yasai-container">
            <?php
            $test_list = [
                'レタス',
                'トマト',
                'じゃがいも',
                'にんじん',
                'たまねぎ',
                'たまねぎ',
                'たまねぎ',
                'たまねぎ',
                'たまねぎ',
                'たまねぎ',
                'たまねぎ',
                'たまねぎ',
                'たまねぎ',
                'たまねぎ',
            ];

            $test_list2 = [
                'yasai.png',
                'yasai.png',
                'yasai.png',
                'yasai.png',
                'yasai.png',
                'yasai.png',
                'yasai.png',
                'yasai.png',
                'yasai.png',
                'yasai.png',
                'yasai.png',

            ];
            ?>


            <?php
            for ($num = 0; $num < 10; $num++) {
            ?>
                <div class="item">
                    <!-- 画像を左に配置 -->
                    <img src="image/<?= $test_list2[$num] ?>" alt="<?= $test_list[$num] ?>">

                    <!-- テキストとコントロールを右に配置するためのコンテナ -->
                    <div class="item-details">
                        <!-- 1. テキストを数値操作の上に配置 -->
                        <div class="item-name">
                            <?php echo $test_list[$num] ?>
                        </div>

                        <!-- 2. 数値操作とボタンを横並びにするコンテナ -->
                        <div class="control-row">
                            <!-- 数値操作 -->
                            <div class="btn-group" role="group" aria-label="数量操作">
                                <button type="button" class="btn btn-primary down">-</button>
                                <input name="<?= $test_list[$num] ?>" type="number" class="textBox btn" value="0">
                                <button type="button" class="btn btn-primary up">+</button>
                            </div>

                            <!-- 3. 変更ボタンと削除ボタンを上下に並べるためのコンテナ -->
                            <div class="action-buttons">
                                <button type="button" class="btn  change-btn">変更</button>
                                <button type="button" class="btn  delete-btn">削除</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    </div>

    <div class="huton">
        <a href="product.php"><button class="suggestion ">手動で追加</button></a>
        <a href="product.php"><button class="suggestion btn-right">冷蔵庫に追加</button></a>
    </div>

</body>

<script>
    document.querySelectorAll('.item').forEach(item => {
        // item-name要素は削除されたため、代わりにitem要素から直接要素を取得
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

        // 変更ボタンと削除ボタンのイベントリスナー（必要に応じて追加）
        const changeBtn = item.querySelector('.change-btn');
        const deleteBtn = item.querySelector('.delete-btn');

        changeBtn.addEventListener('click', () => {
            // item-nameはitem-detailsの子要素になったため、セレクタを修正
            alert(`「${item.querySelector('.item-name').textContent.trim()}」の数量を${box.value}に変更します。`);
            // ここに変更処理を記述
        });

        deleteBtn.addEventListener('click', () => {
            // item-nameはitem-detailsの子要素になったため、セレクタを修正
            if (confirm(`「${item.querySelector('.item-name').textContent.trim()}」を削除しますか？`)) {
                // ここに削除処理を記述
                item.remove(); // 例として要素を削除
            }
        });
    });
</script>


<!-- フッターの読み込み -->
<?php include 'footer.php' ?>