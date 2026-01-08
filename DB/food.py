# import google.generativeai as genai
# import traceback
# import mysql.connector
# from pprint import pprint
# from PIL import Image
# import io
# import os

# def gemini_recipe_example():
#     try:
#         for i in range(404):
#             id = i
#             # id = sys.argv[1] if len(sys.argv) > 1 else "0"
#             conn = mysql.connector.connect(
#                 host="127.0.0.1",      # localhost より 127.0.0.1 が安定
#                 user="root",
#                 password="",
#                 port=3306,
#                 database="cookingai",
#                 use_pure=True          
#             )
#             cursor = conn.cursor()
#             # クエリを実行
#             select_all_data_query = """
#                                     SELECT food_name,
#                                     FROM food_data,
#                                     where food_id = """+str(id)+"""
#                                     """
#             cursor.execute(select_all_data_query)
#             food_items = cursor.fetchall()
#             # APIキー設定
#             genai.configure(api_key="AIzaSyD4vBXreTog5iqkPJ8Q35hk3ONTRi3HoBs")

#             # モデル指定
#             model = genai.GenerativeModel("gemini-2.5-flash-image")

#             # プロンプト
#             prompt = food_items+"""
#                     この食材の画像一つを生成してください。
#                     文字などは表示せず食材だけを出してください。
#                     背景はシンプルでお願いします。
#                     """

#             # 保存先ディレクトリを指定
#             save_dir = "C:/xampp/htdocs/php/cooking-AI-php/image/食材"

#             # 生成リクエスト
#             response = model.generate_content(prompt)
#             for i, part in enumerate(response.parts):
#                 if part.inline_data:  # 画像データがある場合
#                     img = Image.open(io.BytesIO(part.inline_data.data))
#                     file_path = os.path.join(save_dir, f"{id}.png")
#                     img.save(file_path)

        
#     except Exception as e:
#         print(f"❌ 予期しないエラー: {type(e).__name__}")
#         print(f"詳細: {e}")
#         traceback.print_exc()

# if __name__ == "__main__":
#     gemini_recipe_example()
    
import mysql.connector
import os
import io
from PIL import Image
import google.generativeai as genai

def generate_food_images():
    conn = mysql.connector.connect(
        host="127.0.0.1",
        user="root",
        password="",
        port=3306,
        database="cookingai",
        use_pure=True
    )
    cursor = conn.cursor()

    genai.configure(api_key="AIzaSyD4vBXreTog5iqkPJ8Q35hk3ONTRi3HoBs")
    model = genai.GenerativeModel("gemini-2.5-flash-image")

    save_dir = "C:/xampp/htdocs/php/cooking-AI-php/image/食材"
    os.makedirs(save_dir, exist_ok=True)

    for food_id in range(404):
        cursor.execute("SELECT food_name FROM food_data WHERE food_id = %s", (food_id,))
        food_items = cursor.fetchall()

        if not food_items:
            continue

        food_name = food_items[0][0]  # 1件だけ取得
        prompt = f"""{food_name}の画像を生成してください。
        文字などは表示せず食材だけを出してください。
        背景は白でお願いします。
        食材は一つだけお願いします。"""

        response = model.generate_content(prompt)

        for part in response.parts:
            if part.inline_data:
                img = Image.open(io.BytesIO(part.inline_data.data))
                file_path = os.path.join(save_dir, f"{food_id}.png")
                img.save(file_path)

    cursor.close()
    conn.close()

if __name__ == "__main__":
    generate_food_images()