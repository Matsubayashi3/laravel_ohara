<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- メニューの読み込み -->

<!-- DB接続ファイルの読み込み -->
<?php include 'dbconect.php' ?>

<?php
// $_SESSION['user_id']が設定されていない場合のWarning対策
// ログイン機能が未実装、またはログインしていない状態でアクセスされた場合を想定し、
// 暫定的にuser_idを1に設定するか、適切なエラー処理を行う。
// ここでは、user_idが未設定の場合は0として、SQL側で対応できるようにする。
// ただし、stock_dataのuser_idはINT UNSIGNED NOT NULLなので、0は適切ではない可能性がある。
// ログイン必須のページであればリダイレクトが望ましいが、ここでは暫定的に1を設定する。
if (!isset($_SESSION['user_id'])) {
    // 警告を避けるため、暫定的にテストユーザーID (1) を設定
    // 実際の運用ではログインページへのリダイレクトが必要です
    $_SESSION['user_id'] = 1;
}
?>


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
$id = $_SESSION['users_data']['user_id'];
?>

<style>
    html {
        background-color: #FCC800;
    }

    body {
        background-color: #FCC800;
    }

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
        border-radius: 30px;
    }

    .food-container {
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
        /* background: none; */
        font-size: 18px;
        text-align: center;
        width: 70px;
        background-color: #fff;
    }

    .textBox {
        border: none;
        font-size: 18px;
        text-align: center;
        width: 70px;
        background-color: #fff;
        pointer-events: none;
        user-select: none;
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
        border: none;
        padding: 8px 16px;
        background-color: #E97132;
        border-radius: 8px;
    }

    .huton {
        text-align: center;
    }

    a {
        text-decoration: none;
    }

    .modoru {
        background-color: #E97132;
        color: #fff;
        border: none;
        padding: 6px 12px;
        margin-top: 20px;
        margin-left: 30px;
        margin-bottom: 20px;
        border-radius: 8px;
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

        .food-container {
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
            background-color: #fff;
        }

        .btn-group {
            transform: scale(0.8);
            /* 全体を少し縮小 */
            margin-top: 5px;
        }

        .food-container {
            gap: 15px;
        }
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
        margin: 0;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<body>
    <a href="select.php"><button class="modoru">戻る</button></a>

    <div class="tab-3">
        <!-- 野菜タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3" checked>
            野菜
        </label>

        <div>
            <div class="food-container">
                <?php
                // 野菜データを取得
                $sql_yasai = $pdo->prepare('SELECT fd.food_name, fd.food_id, sd.count FROM food_data fd JOIN stock_data sd ON fd.food_id = sd.food_id WHERE fd.food_category = "野菜" AND sd.count > 0 AND sd.user_id = :user_id');
                $sql_yasai->bindValue(':user_id', $id, PDO::PARAM_INT);
                $sql_yasai->execute();
                $yasai_list = $sql_yasai->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <!-- 数量操作ボタン -->
                <?php
                if ($yasai_list == null) {
                    echo "在庫がありません";
                } else {
                    foreach ($yasai_list as $item) {
                ?>
                        <div class="item">
                            <img src="image/食材/<?= $item['food_id'] ?>.png" alt="<?= $item['food_name'] ?>" style="border-radius: 30px;">
                            <?php echo $item['food_name'] ?>
                            <div class="btn-group" role="group" aria-label="数量操作">
                                <button type="button" class="btn btn-primary down">-</button>
                                <input name="<?= $item['food_name'] ?>" type="number" class="textBox btn" value="<?= $item['count'] ?>">
                                <button type="button" class="btn btn-primary up">+</button>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>


        <!-- 肉タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            肉
        </label>

        <div>
            <div class="food-container">
                <?php
                // 肉データを取得
                $sql_niku = $pdo->prepare('SELECT fd.food_name, fd.food_id, sd.count FROM food_data fd JOIN stock_data sd ON fd.food_id = sd.food_id WHERE fd.food_category = "肉" AND sd.count > 0 AND sd.user_id = :user_id');
                $sql_niku->bindValue(':user_id', $id, PDO::PARAM_INT);
                $sql_niku->execute();
                $niku_list = $sql_niku->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <!-- 数量操作ボタン -->
                <?php
                if ($niku_list == null) {
                    echo "在庫がありません";
                } else {
                    foreach ($niku_list as $item) {
                ?>
                        <div class="item">
                            <img src="image/食材/<?= $item['food_id'] ?>.png" alt="<?= $item['food_name'] ?>">
                            <?php echo $item['food_name'] ?>
                            <div class="btn-group" role="group" aria-label="数量操作">
                                <button type="button" class="btn btn-primary down">-</button>
                                <input name="<?= $item['food_name'] ?>" type="number" class="textBox btn" value="<?= $item['count'] ?>">
                                <button type="button" class="btn btn-primary up">+</button>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>


        <!-- 魚タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            魚
        </label>

        <div>
            <div class="food-container">
                <?php
                // 魚データを取得
                $sql_sakana = $pdo->prepare('SELECT fd.food_name, fd.food_id, sd.count FROM food_data fd JOIN stock_data sd ON fd.food_id = sd.food_id WHERE fd.food_category = "魚" AND sd.count > 0 AND sd.user_id = :user_id');
                $sql_sakana->bindValue(':user_id', $id, PDO::PARAM_INT);
                $sql_sakana->execute();
                $sakana_list = $sql_sakana->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <!-- 数量操作ボタン -->
                <?php
                if ($sakana_list == null) {
                    echo "在庫がありません";
                } else {
                    foreach ($sakana_list as $item) {
                ?>
                        <div class="item">
                            <img src="image/食材/<?= $item['food_id'] ?>.png" alt="<?= $item['food_name'] ?>">
                            <?php echo $item['food_name'] ?>
                            <div class="btn-group" role="group" aria-label="数量操作">
                                <button type="button" class="btn btn-primary down">-</button>
                                <input name="<?= $item['food_name'] ?>" type="number" class="textBox btn" value="<?= $item['count'] ?>">
                                <button type="button" class="btn btn-primary up">+</button>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>

        <!-- 主食-粉タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            主食-粉
        </label>

        <div>
            <div class="food-container">
                <?php
                // 主食-粉データを取得
                $sql_syusyoku = $pdo->prepare('SELECT fd.food_name, fd.food_id, sd.count FROM food_data fd JOIN stock_data sd ON fd.food_id = sd.food_id WHERE fd.food_category = "主食-粉" AND sd.count > 0 AND sd.user_id = :user_id');
                $sql_syusyoku->bindValue(':user_id', $id, PDO::PARAM_INT);
                $sql_syusyoku->execute();
                $syusyoku_list = $sql_syusyoku->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <!-- 数量操作ボタン -->
                <?php
                if ($syusyoku_list == null) {
                    echo "在庫がありません";
                } else {
                    foreach ($syusyoku_list as $item) {
                ?>
                        <div class="item">
                            <img src="image/食材/<?= $item['food_id'] ?>.png" alt="<?= $item['food_name'] ?>">
                            <?php echo $item['food_name'] ?>
                            <div class="btn-group" role="group" aria-label="数量操作">
                                <button type="button" class="btn btn-primary down">-</button>
                                <input name="<?= $item['food_name'] ?>" type="number" class="textBox btn" value="<?= $item['count'] ?>">
                                <button type="button" class="btn btn-primary up">+</button>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>

        <!--乳製品タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            乳製品
        </label>

        <div>
            <div class="food-container">
                <?php
                // 乳製品データを取得
                $sql_nyu = $pdo->prepare('SELECT fd.food_name, fd.food_id, sd.count FROM food_data fd JOIN stock_data sd ON fd.food_id = sd.food_id WHERE fd.food_category = "乳製品" AND sd.count > 0 AND sd.user_id = :user_id');
                $sql_nyu->bindValue(':user_id', $id, PDO::PARAM_INT);
                $sql_nyu->execute();
                $nyu_list = $sql_nyu->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <!-- 数量操作ボタン -->
                <?php
                if ($nyu_list == null) {
                    echo "在庫がありません";
                } else {
                    foreach ($nyu_list as $item) {
                ?>
                        <div class="item">
                            <img src="image/食材/<?= $item['food_id'] ?>.png" alt="<?= $item['food_name'] ?>">
                            <?php echo $item['food_name'] ?>
                            <div class="btn-group" role="group" aria-label="数量操作">
                                <button type="button" class="btn btn-primary down">-</button>
                                <input name="<?= $item['food_name'] ?>" type="number" class="textBox btn" value="<?= $item['count'] ?>">
                                <button type="button" class="btn btn-primary up">+</button>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>

        <!-- 果物タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            果物
        </label>

        <div>
            <div class="food-container">
                <?php
                // 果物データを取得
                $sql_fruit = $pdo->prepare('SELECT fd.food_name, fd.food_id, sd.count FROM food_data fd JOIN stock_data sd ON fd.food_id = sd.food_id WHERE fd.food_category = "果物" AND sd.count > 0 AND sd.user_id = :user_id');
                $sql_fruit->bindValue(':user_id', $id, PDO::PARAM_INT);
                $sql_fruit->execute();
                $fruit_list = $sql_fruit->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <!-- 数量操作ボタン -->
                <?php
                if ($fruit_list == null) {
                    echo "在庫がありません";
                } else {
                    foreach ($fruit_list as $item) {
                ?>
                        <div class="item">
                            <img src="image/食材/<?= $item['food_id'] ?>.png" alt="<?= $item['food_name'] ?>">
                            <?php echo $item['food_name'] ?>
                            <div class="btn-group" role="group" aria-label="数量操作">
                                <button type="button" class="btn btn-primary down">-</button>
                                <input name="<?= $item['food_name'] ?>" type="number" class="textBox btn" value="<?= $item['count'] ?>">
                                <button type="button" class="btn btn-primary up">+</button>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>

        <!-- その他タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            その他
        </label>

        <div>
            <div class="food-container">
                <?php
                // その他データを取得
                $sql_sonota = $pdo->prepare('SELECT fd.food_name, fd.food_id, sd.count FROM food_data fd JOIN stock_data sd ON fd.food_id = sd.food_id WHERE fd.food_category = "その他" AND sd.count > 0 AND sd.user_id = :user_id');
                $sql_sonota->bindValue(':user_id', $id, PDO::PARAM_INT);
                $sql_sonota->execute();
                $sonota_list = $sql_sonota->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <!-- 数量操作ボタン -->
                <?php
                if ($sonota_list == null) {
                    echo "在庫がありません";
                } else {
                    foreach ($sonota_list as $item) {
                ?>
                        <div class="item">
                            <img src="image/食材/<?= $item['food_id'] ?>.png" alt="<?= $item['food_name'] ?>">
                            <?php echo $item['food_name'] ?>
                            <div class="btn-group" role="group" aria-label="数量操作">
                                <button type="button" class="btn btn-primary down">-</button>
                                <input name="<?= $item['food_name'] ?>" type="number" class="textBox btn" value="<?= $item['count'] ?>">
                                <button type="button" class="btn btn-primary up">+</button>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>

        <!-- 調味料タグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            調味料
        </label>

        <div>
            <div class="food-container">
                <?php
                // 調味料データを取得
                $sql_tyoumi = $pdo->prepare('SELECT fd.food_name, fd.food_id, sd.count FROM food_data fd JOIN stock_data sd ON fd.food_id = sd.food_id WHERE fd.food_category = "調味料" AND sd.count > 0 AND sd.user_id = :user_id');
                $sql_tyoumi->bindValue(':user_id', $id, PDO::PARAM_INT);
                $sql_tyoumi->execute();
                $tyoumi_list = $sql_tyoumi->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <!-- 数量操作ボタン -->
                <?php
                if ($tyoumi_list == null) {
                    echo "在庫がありません";
                } else {
                    foreach ($tyoumi_list as $item) {
                ?>
                        <div class="item">
                            <img src="image/食材/<?= $item['food_id'] ?>.png" alt="<?= $item['food_name'] ?>">
                            <?php echo $item['food_name'] ?>
                            <div class="btn-group" role="group" aria-label="数量操作">
                                <button type="button" class="btn btn-primary down">-</button>
                                <input name="<?= $item['food_name'] ?>" type="number" class="textBox btn" value="<?= $item['count'] ?>">
                                <button type="button" class="btn btn-primary up">+</button>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>

        <!-- スパイスタグの中身 -->
        <label>
            <input class="tab-c" type="radio" name="tab-3">
            スパイス
        </label>

        <div>
            <div class="food-container">
                <?php
                // スパイスデータを取得
                $sql_spice = $pdo->prepare('SELECT fd.food_name, fd.food_id, sd.count FROM food_data fd JOIN stock_data sd ON fd.food_id = sd.food_id WHERE fd.food_category = "スパイス" AND sd.count > 0 AND sd.user_id = :user_id');
                $sql_spice->bindValue(':user_id', $id, PDO::PARAM_INT);
                $sql_spice->execute();
                $spice_list = $sql_spice->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <!-- 数量操作ボタン -->
                <?php
                if ($spice_list == null) {
                    echo "在庫がありません";
                } else {
                    foreach ($spice_list as $item) {
                ?>
                        <div class="item">
                            <img src="image/食材/<?= $item['food_id'] ?>.png" alt="<?= $item['food_name'] ?>">
                            <?php echo $item['food_name'] ?>
                            <div class="btn-group" role="group" aria-label="数量操作">
                                <button type="button" class="btn btn-primary down">-</button>
                                <input name="<?= $item['food_name'] ?>" type="number" class="textBox btn" value="<?= $item['count'] ?>">
                                <button type="button" class="btn btn-primary up">+</button>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>


    </div>

    <div class="huton">
        <a href="suggestion.php" id="recipe-search"><button class="suggestion ">レシピ検索</button></a>
    </div>

    <!-- ローディング画面 -->
    <div class="loading-overlay" id="loading">
        <div class="loading-content">
            <div class="spinner"></div>
            <p class="loading-text">レシピを検索中...</p>
        </div>
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

    // レシピ検索ボタンのローディング処理
    document.getElementById('recipe-search').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('loading').style.display = 'flex';
        setTimeout(() => {
            window.location.href = 'suggestion.php';
        }, 100);
    });
</script>


<!-- フッターの読み込み -->
<?php include 'footer.php' ?>