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
    .tab-3 {
        display: flex;
        flex-wrap: wrap;
        max-width: 500px;
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
</style>


<div class="tab-3">
    <label>
        <input class="tab-c" type="radio" name="tab-3" checked>
        野菜
    </label>
    <?php
    $test_list = [
        'レタス',
        'じゃがいも',
        'トマト',
        'にんじん',
        'たまねぎ',
    ];

    for ($num = 0; $num < 5; $num++) {
    ?>
        <div>
            <img src="image/yasai.png" alt="<?php echo $test_list[$num] ?>">
            <div class="qty">
                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn btn-warning" id='down'>-</button>
                    <input name="<?php $test_list[$num] ?>" type="number" id="textBox" class="btn btn-warning">
                    <button type="button" class="btn btn-success" id='up'>+</button>
                </div>
            </div>
        </div>
    <?php } ?>

    <label>
        <input class="tab-c" type="radio" name="tab-3">
        肉
    </label>
    <div>ぜひお好みの色にアレンジしてみてください。</div>

    <label>
        <input class="tab-c" type="radio" name="tab-3">
        魚
    </label>
    <div>もちろんレスポンシブ対応で、タブの追加にも対応しています。</div>
</div>

<script>
    const qtyDown = document.getElementById('down');
    const qtyUp = document.getElementById('up');
    const qtyText = document.getElementById('textBox');
    let num = 1;
    qtyText.value = num;

    qtyDown.addEventListener('click', () => {
        if (parseInt(qtyText.value) >= 2) { // 1以下にならないように設定
            num--;
            qtyText.value = num;
        }
    });
    qtyUp.addEventListener('click', () => {
        num++;
        qtyText.value = num;
    });
</script>

<!-- フッターの読み込み -->
<?php include 'footer.php' ?>