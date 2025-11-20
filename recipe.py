import google.generativeai as genai
import traceback
import mysql.connector
from pprint import pprint
from PIL import Image
import io
import os

def gemini_recipe_example():
    try:
        # id = sys.argv[1] if len(sys.argv) > 1 else "0"
<<<<<<< HEAD
        id = 4 # テスト用に固定
=======
        id = 3
        # MySQLに接続（use_pure=True で C 拡張によるクラッシュを回避）
>>>>>>> fb77f661e9da29baedb65e52f4f31451f2e07f64
        conn = mysql.connector.connect(
            host="127.0.0.1",      # localhost より 127.0.0.1 が安定
            user="root",
            password="",
            port=3306,
            database="cookingai",
            use_pure=True          
        )
        cursor = conn.cursor()
        # クエリを実行
        select_all_data_query = """
                                SELECT fd.food_name, sd.count
                                FROM food_data fd
                                JOIN stock_data sd ON fd.food_id = sd.food_id
                                WHERE sd.count > 0 AND sd.user_id = """+str(id)+"""
                                """
        cursor.execute(select_all_data_query)
        food_items = cursor.fetchall()
        # print(food_items)
<<<<<<< HEAD
        # genai.configure(api_key="AIzaSyD5eSZoK_qCu6vgsmybbqmlMRqpcea62Ds")
        genai.configure(api_key="AIzaSyD4vBXreTog5iqkPJ8Q35hk3ONTRi3HoBs")
        
        model = genai.GenerativeModel("gemini-2.5-flash")
        prompt = "冷蔵庫にある食材からレシピを提案してください" + str(food_items) + \
         "これらの食材を使った簡単で美味しい料理のレシピを1つ教えてください。" \
         '文字列として出力してください。' \
         '形式: [["料理名", [["食材名", 数量], ["食材名", 数量], ...]]]'
=======
        genai.configure(api_key="AIzaSyD5eSZoK_qCu6vgsmybbqmlMRqpcea62Ds")
        model = genai.GenerativeModel("gemini-2.5-flash")
        prompt = "冷蔵庫にある食材からレシピを提案してください"+str(food_items)+\
                    "これらの食材を使った簡単で美味しい料理のレシピ1つを教えてください。""""
                    返り値を配列として登録するのを想定していますので、以下の形式のみで出力すること。
#                   [["料理名"]][[食材名, 数量], [食材名, 数量], ...]
                    """
>>>>>>> fb77f661e9da29baedb65e52f4f31451f2e07f64
        response = model.generate_content([prompt])
        foods = response.text
        print(foods)
        
        # APIキー設定
        genai.configure(api_key="AIzaSyD4vBXreTog5iqkPJ8Q35hk3ONTRi3HoBs")

        # モデル指定
        model = genai.GenerativeModel("gemini-2.5-flash-image")

        # プロンプト
        prompt = foods+"""この料理の画像一つを生成してください。
                文字などは表示せず料理だけを出してください。
                画像は美味しそうに見えるようにしてください。
                """

        # 保存先ディレクトリを指定
        save_dir = "C:/xampp/htdocs/php/cooking-AI-php/image/recipe"

        # 生成リクエスト
        response = model.generate_content(prompt)

        # parts から画像を取り出して保存
        for i, part in enumerate(response.parts):
            if part.inline_data:  # 画像データがある場合
                img = Image.open(io.BytesIO(part.inline_data.data))
                file_path = os.path.join(save_dir, f"{id}.png")
                img.save(file_path)
        
        cursor.close()
        conn.close()
    except Exception as e:
        print(f"❌ 予期しないエラー: {type(e).__name__}")
        print(f"詳細: {e}")
        traceback.print_exc()

if __name__ == "__main__":
    gemini_recipe_example()