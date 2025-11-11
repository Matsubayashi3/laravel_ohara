import mysql.connector
from mysql.connector import Error
import traceback
import sys

def create_all_tables():
    connection = None
    cursor = None
    try:
        connection = mysql.connector.connect(
            host='127.0.0.1',
            user='root',
            password='',
            database='cookingai',
            use_pure=True
        )

        if connection is not None and connection.is_connected():
            cursor = connection.cursor()

            # users_data
            cursor.execute("DROP TABLE IF EXISTS stock_data")
            cursor.execute("DROP TABLE IF EXISTS food_data")
            cursor.execute("DROP TABLE IF EXISTS users_data")

            cursor.execute("""
            CREATE TABLE users_data (
                user_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                user_name VARCHAR(50) NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at DATETIME DEFAULT current_timestamp(0),
                updated_at DATETIME DEFAULT current_timestamp(0)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            """)

            # food_data
            cursor.execute("""
            CREATE TABLE food_data (
                food_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                food_category VARCHAR(50) NOT NULL,
                food_name VARCHAR(100) NOT NULL,
                created_at DATETIME DEFAULT current_timestamp(0),
                updated_at DATETIME DEFAULT current_timestamp(0)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            """)

            # stock_data
            cursor.execute("""
            CREATE TABLE stock_data (
                user_id INT UNSIGNED NOT NULL,
                food_id INT UNSIGNED NOT NULL,
                count INT NOT NULL,
                created_at DATETIME DEFAULT current_timestamp(0),
                updated_at DATETIME DEFAULT current_timestamp(0),
                FOREIGN KEY (user_id) REFERENCES users_data(user_id),
                FOREIGN KEY (food_id) REFERENCES food_data(food_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            """)

            connection.commit()
            print("✅ すべてのテーブルが作成されました。")

    except Exception as e:
        # mysql.connector.Error 以外の例外も含めてトレースバックを出力
        print(f"エラーが発生しました: {e}")
        traceback.print_exc()

    finally:
        try:
            if connection is not None and connection.is_connected():
                if cursor is not None:
                    cursor.close()
                connection.close()
                print("接続終了")
        except Exception:
            # 最後のクリーンアップで例外が起きてもトレースを出して終了
            traceback.print_exc()


if __name__ == "__main__":
    try:
        create_all_tables()
    except Exception:
        traceback.print_exc()
        sys.exit(1)