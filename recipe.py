import google.generativeai as genai
import traceback
import sys
import mysql.connector
import json 
from pprint import pprint


def gemini_recipe_example():
    try:
        # id = sys.argv[1] if len(sys.argv) > 1 else "0"
        id = 4 # テスト用に固定
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
        print(food_items)
        # genai.configure(api_key="AIzaSyD5eSZoK_qCu6vgsmybbqmlMRqpcea62Ds")
        genai.configure(api_key="AIzaSyD4vBXreTog5iqkPJ8Q35hk3ONTRi3HoBs")
        
        model = genai.GenerativeModel("gemini-2.5-flash")
        prompt = "冷蔵庫にある食材からレシピを提案してください" + str(food_items) + \
         "これらの食材を使った簡単で美味しい料理のレシピを1つ教えてください。" \
         '文字列として出力してください。' \
         '形式: [["料理名", [["食材名", 数量], ["食材名", 数量], ...]]]'
        response = model.generate_content([prompt])
        foods = response.text
        print(foods)
        
        
        cursor.close()
        conn.close()
    except Exception as e:
        print(f"❌ 予期しないエラー: {type(e).__name__}")
        print(f"詳細: {e}")
        traceback.print_exc()

if __name__ == "__main__":
    gemini_recipe_example()