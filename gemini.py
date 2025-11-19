# import httpx
# import base64
# import google.generativeai as genai
# import traceback

# try:
#     genai.configure(api_key="AIzaSyD5eSZoK_qCu6vgsmybbqmlMRqpcea62Ds")

#     model = genai.GenerativeModel("gemini-2.5-flash")

#     image_url = "https://osaka-ainou.jp/images/convert/osaka-ainoujp/20240718082815.jpg/image.webp"
#     # print(f"画像を取得中: {image_url}")
#     # Wikipedia は user-agent を要求しているため、ヘッダーを追加
#     headers = {
#         'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
#     }
#     response_img = httpx.get(image_url, headers=headers, timeout=30.0)

#     # 画像取得成功か確認
#     if response_img.status_code == 200:
#         # print(f"✅ 画像取得成功 ({len(response_img.content)} bytes)")
#         image_data = base64.b64encode(response_img.content).decode("utf-8")
#         prompt = """画像の食材の個数を教えてください返り値は以下の例でお願いします。
#         返り値を配列として登録するのを想定していますので、以下の形式のみで出力すること。
#         ['キャベツ',1],['にんじん',2],['たまねぎ',16]
#         """

#         # print("Gemini API に送信中...")
#         response = model.generate_content([
#             {'mime_type': 'image/jpeg', 'data': image_data},
#             prompt
#         ])
#         # print("✅ レスポンス取得成功")
#         print(response.text)
#     else:
#         print(f"❌ 画像の取得に失敗しました。ステータスコード: {response_img.status_code}")
#         print(f"レスポンス本文: {response_img.text[:300]}")

# except httpx.HTTPError as e:
#     print(f"❌ HTTP エラー: {e}")
#     traceback.print_exc()
# except Exception as e:
#     print(f"❌ エラー発生: {type(e).__name__}: {e}")
#     traceback.print_exc()

# ここまでネット上の画像を使う例
# ここからローカル画像を使う例

import base64
import google.generativeai as genai
import traceback
import sys
import json
import httpx
 
 
def gemini_image_example():
    try:
        id = sys.argv[1] if len(sys.argv) > 1 else "0"
        food ="たまねぎ, にんじん, じゃがいも, キャベツ, ネギ, 大根, トマト, ピーマン, きゅうり, しょうが, ニンニク, しそ, ナス, かぼちゃ, しいたけ, しめじ, えのき, ブロッコリー, もやし, 豆苗, 白菜, ほうれん草, ニラ, アボカド, パプリカ, ミニトマト, さつまいも, ごぼう, れんこん, オクラ, トウモロコシ, アスパラガス, エリンギ, マイタケ, マッシュルーム, 小松菜, チンゲンサイ, 水菜, かぶ, さといも, 長いも, セロリ, ズッキーニ, ゴーヤ, トマト缶, コーン, ミックスベジタブル, えんどう豆, いんげん豆, えだまめ, 切り干し大根, みょうが, 干しシイタケ, きくらげ, ししとう, なめこ, たくあん, 高菜, らっきょう, かいわれ大根, みつば, ベビーリーフ, クレソン, ルッコラ, 芽キャベツ, ラディッシュ, ベビーコーン, そらまめ, にんにくの芽, グリーンピース, 菜の花, 春菊, 野沢菜, モロヘイヤ, 空心菜, ピクルス, クリームコーン, ビーツ, マツタケ, ぎんなん, うり, ふき, うど, せり, たけのこ, たらの芽, 菊, ぜんまい, こごみ, ゆり根, じゅんさい, かんきつ類, 鶏もも肉, 鶏むね肉, 鶏ささみ, 鶏手羽肉, 砂肝, 鶏レバー, 牛ひき肉, 豚ひき肉, 鶏ひき肉, 豚ロース肉, 豚もも肉, 豚バラ肉, 豚ヒレ肉, 豚レバー, 豚もつ, 牛バラ肉, 牛ヒレ肉, 牛もも肉, 牛ロース肉, 牛タン, 牛レバー, 鶏皮, ラム肉, 鴨肉, ベーコン, ソーセージ, ハム, チャーシュー, スパム, コンビーフ, サラミ, サケ, さば, まぐろ, サーモン, ぶり, タラ, たい, カツオ, カジキ, さんま, イワシ, アジ, ししゃも, かれい, ひらめ, スズキ, ほっけ, きす, ムツ, タチウオ, キンキ, ニシン, メバル, はも, カワハギ, ワカサギ, あゆ, ウナギ, あなご, イカ, タコ, エビ, 甘エビ, 伊勢エビ, カニ, あさり, しじみ, ホタテ, 牡蠣, 貝柱, はまぐり, ムール貝, あわび, ばか貝, 赤貝, ばい貝, しらす, たらこ, さくらえび, いくら, とびっこ, ウニ, かずのこ, しらこ, ほたるいか, くらげ, シーフードミックス, ツナ缶, さば缶, さけ缶, ちくわ, かまぼこ, はんぺん, 魚肉ソーセージ, めかぶ, 米, うどん, 麺, パスタ, ショートパスタ, そば, 食パン, パン, フランスパン, もち, そうめん, 春雨, 小麦粉, 片栗粉, お好み焼き粉, ホットケーキミックス, ベーキングパウダー, もち米, 玄米, そば米, ドライイースト, ゼラチン, ココア, 米粉, コーンスターチ, てんぷら粉, 白玉粉, 上新粉, 雑穀米, くず粉, 押し麦, そば粉, 玄米粉, 卵, 牛乳, 豆腐, ヨーグルト, クリーム, プロセスチーズ, スライスチーズ, 豆乳, 納豆, 油揚げ, 厚揚げ, 粉チーズ, クリームチーズ, モッツアレラチーズ, カマンベールチーズ, チーズ, 豆, 大豆, きなこ, おから, あずき, 高野豆腐, 湯葉, スキムミルク, ココナッツミルク, サワークリーム, うずらの卵, ピータン, リンゴ, バナナ, オレンジ, いちご, キウイ, ブルーベリー, ジャム, ピーナッツバター, チョコレート, レーズン, ナッツ, 香料, リキュール, ブランデー, メープルシロップ, 黒みつ, あんこ, もも, ぶどう, パイナップル, グレープフルーツ, マンゴー, みかん, スイカ, メロン, さくらんぼ, 柿, 梨, あんず, クランベリー, プルーン, 洋なし, きんかん, プラム, パパイヤ, くり, オレンジジュース, リンゴジュース, ぶどうジュース, アイスクリーム, マシュマロ, クラッカー, コーンフレーク, 水あめ, ワカメ, ひじき, のり, かつお節, 昆布, こんにゃく, しらたき, ごま, 塩昆布, 天かす, とろろこんぶ, 青のり, キムチ, ザーサイ, メンマ, アンチョビ, オリーブ, ホワイトソース, がんも, さつま揚げ, ぎょうざの皮, ライスペーパー, もずく, ところてん, 松の実, ゆかり, かんぴょう, 麩, 酒かす, コーヒー, 紅茶, 茶, 甘栗, 甘酒, 梅, 梅干し, 梅酒, トマトジュース, 野菜ジュース, 抹茶, ポテトチップス, 塩, 胡椒, 砂糖, 醤油, 料理酒, みりん, 酢, 味噌, バター, サラダ油, オリーブオイル, ごま油, マヨネーズ, ケチャップ, ドレッシング, レモン汁, めんつゆ, ソース, はちみつ, 豆板醤, 豆鼓, 甜面醤, おろしにんにく, おろししょうが, オイスターソース, スープの素, わさび, からし, ワイン, ポン酢, マスタード, ラー油, コチュジャン, 柚子胡椒, ナンプラー, バルサミコ酢, タバスコ, デミグラスソース, チリソース, 塩こうじ, たれ, カレー粉, パセリ, バジル, シナモン, ローリエ, ナツメグ, パクチー, とうがらし, ローズマリー, 山椒, クミン, ターメリック, サフラン, オールスパイス, ガーリックパウダー, オレガノ, タイム, ミント, 八角, チリパウダー, パプリカパウダー, クローブ, カルダモン, ディル, セージ, レモングラス, チャービル"
       
        genai.configure(api_key="AIzaSyD5eSZoK_qCu6vgsmybbqmlMRqpcea62Ds")
        model = genai.GenerativeModel("gemini-2.5-flash")
 
        # ローカル画像ファイルのパス
        image_path = "http://localhost/php/cooking-AI-php/image/freeze/add_"+id+".jpg"
        # image_path = "https://osaka-ainou.jp/images/convert/osaka-ainoujp/20240718082815.jpg/image.webp"
        image_data2 = httpx.get(image_path)
        # with open(image_path, "rb") as f:
        #     image_bytes = f.read()
        image_data = base64.b64encode(image_data2.content).decode("utf-8")
 
        prompt = """画像の食材の個数を教えてください返り値は以下の例でお願いします。
                 食材名は"""+food+"""ここから参照してください
#                返り値を配列として登録するのを想定していますので、以下の形式のみで出力すること。
#                [["ブロッコリー", 1], ["かぼちゃ", 2],["小松菜",2]]
#                """
        response = model.generate_content([
            {'mime_type': 'image/png', 'data': image_data},
            prompt
        ])
        gemini = response.text
        # print(json.dumps(gemini, ensure_ascii=False))
        print(gemini)
 
 
    except Exception as e:
        print(f"❌ 予期しないエラーが発生しました: {type(e).__name__}")
        print(f"詳細: {e}")
        traceback.print_exc()
       
# if __name__ == "__main__":
try:
    gemini_image_example()
except Exception:
    traceback.print_exc()