<!-- 共通ブロック -->
<!-- セッションの開始 -->
<?php session_start(); ?>
<!-- ヘッダーの読み込み -->
<?php include 'header.php' ?>
<!-- メニューの読み込み -->

<!-- DB接続ファイルの読み込み -->
<?php
// foodcheck.phpと同様のDB接続情報を使用
$dsn = 'mysql:host=127.0.0.1;dbname=cookingai;charset=utf8mb4';
$user = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo '<p style="color: red;">データベース接続エラー: ' . $e->getMessage() . '</p>';
    exit;
}

// ユーザーIDの仮設定 (foodcheck.phpと合わせる)
$user_id = 1;

// 画像ファイル名を取得する関数 (food_idを使用するように変更)
function get_food_image_path($food_id)
{
    // image/食材/food_id.jpg の形式でパスを生成
    return "image/食材/{$food_id}.jpg";
}

// --- stock_dataから食材データを取得 ---
$stock_data = [];
try {
    // stock_data, food_data, users_dataを結合して、食材名と数量を取得
    $sql = "
        SELECT
            t1.count,
            t2.food_id,
            t2.food_name,
            t2.food_category
        FROM
            stock_data t1
        JOIN
            food_data t2 ON t1.food_id = t2.food_id
        WHERE
            t1.user_id = :user_id
        ORDER BY
            t2.food_category, t2.food_name
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $stock_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '<p style="color: red;">食材データ取得エラー: ' . $e->getMessage() . '</p>';
}

// カテゴリごとにデータをグループ化
$grouped_stock = [];
foreach ($stock_data as $item) {
    $category = $item['food_category'] ?? '未分類';
    $grouped_stock[$category][] = $item;
}

// タブのカテゴリ順序を定義 (food_stock.phpのHTML構造に合わせる)
$tab_categories = ['野菜', '肉', '魚', '未分類']; // 未分類はDBにfood_categoryがない場合を想定

?>


<!-- 個別ブロック -->
<!-- 検索ブロック -->
<!-- <form action='product.php' method='post'>
    商品検索
    <input type='text' name='search'>
    <input type='submit' value='検索'>
</form>
<hr> -->

<style>
    /* pasted_content_4.txtのスタイルを適用 */
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
        /* 画面サイズに合わせて調整 */
        min-width: 120px;
    }

    /* ボタン */
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
        <?php
        // タブのカテゴリをループ
        foreach ($tab_categories as $index => $category):
            $is_checked = ($index === 0) ? 'checked' : '';
            $category_data = $grouped_stock[$category] ?? [];
        ?>
            <label>
                <input class="tab-c" type="radio" name="tab-3" <?= $is_checked ?>>
                <?= htmlspecialchars($category) ?>
            </label>

            <div>
                <!-- 食材がない場合 -->
                <?php if (empty($category_data)): ?>
                    <p style="text-align: center; color: #999;">このカテゴリの食材は登録されていません。</p>
                <?php else: ?>
                    <div class="yasai-container">
                        <?php foreach ($category_data as $item): ?>
                            <?php
                            $food_id = $item['food_id']; // food_idを取得
                            $food_name = $item['food_name'];
                            $count = $item['count'];
                            $image_path = get_food_image_path($food_id); // food_idから画像パスを取得
                            ?>
                            <div class="item">
                                <img src="<?= htmlspecialchars($image_path) ?>" alt="<?= htmlspecialchars($food_name) ?>">
                                <?= htmlspecialchars($food_name) ?>
                                <div class="btn-group" role="group" aria-label="数量操作">
                                    <!-- IDではなくクラスを使用し、JavaScriptで処理 -->
                                    <button type="button" class="btn btn-warning down">-</button>
                                    <input name="<?= htmlspecialchars($food_name) ?>" type="number" class="textBox btn" value="<?= htmlspecialchars($count) ?>">
                                    <button type="button" class="btn btn-success up">+</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="huton">
        <a href="suggestion.php"><button class="suggestion ">レシピ検索</button></a>
    </div>

</body>

<script>
    // foodcheck.phpのJavaScriptを流用し、クラス名に合わせて修正
    document.querySelectorAll('.item').forEach(item => {
        // item内の要素をクラス名で取得
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

        // food_stock.phpには変更・削除ボタンがないため、関連する処理は削除
    });
</script>


<!-- フッターの読み込み -->
<?php include 'footer.php' ?>