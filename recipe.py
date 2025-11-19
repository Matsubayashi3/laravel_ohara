import google.generativeai as genai
import traceback
import sys
import mysql.connector
import json 
from pprint import pprint


def gemini_recipe_example():
    try:
        # id = sys.argv[1] if len(sys.argv) > 1 else "0"
        id = 4
        # MySQLに接続（use_pure=True で C 拡張によるクラッシュを回避）
        conn = mysql.connector.connect(
            host="127.0.0.1",      # localhost より 127.0.0.1 がより安定
            user="root",
            password="",
            port=3306,
            database="cookingai",
            use_pure=True          # Pure Python 実装を使用
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
        genai.configure(api_key="AIzaSyD5eSZoK_qCu6vgsmybbqmlMRqpcea62Ds")
        model = genai.GenerativeModel("gemini-2.5-flash")
        prompt = "冷蔵庫にある食材からレシピを提案してください"+str(food_items)+\
                    "これらの食材を使った簡単で美味しい料理のレシピを教えてください。""""
                    返り値を配列として登録するのを想定していますので、以下の形式のみで出力すること。
#                   [["料理名"]][[食材名, 数量], [食材名, 数量], ...]
                    
                    
                    """
                    
        response = model.generate_content([prompt])
        gemini = response.text
        print(gemini)
        
        
        
        
        
        cursor.close()
        conn.close()
    except Exception as e:
        print(f"❌ 予期しないエラー: {type(e).__name__}")
        print(f"詳細: {e}")
        traceback.print_exc()

if __name__ == "__main__":
    gemini_recipe_example()