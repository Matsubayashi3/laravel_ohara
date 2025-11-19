# my_python_return_data.py

import json
import sys

def main():
    # コマンドライン引数を取得
    # sys.argv[0] はスクリプト名自身
    # PHPから渡された引数を受け取ります
    name = sys.argv[1] if len(sys.argv) > 1 else "ゲスト"
    # 年齢は整数として受け取ります。文字列からの変換に失敗した場合に備えてtry-exceptも考慮するとより堅牢になります。
    try:
        age = int(sys.argv[2]) if len(sys.argv) > 2 else 0
    except ValueError:
        age = 0 # 無効な値が渡された場合は0とする

    # PHPに返したいデータをPythonの辞書として作成します。
    result_data = {
        "message": f"こんにちは、{name}さん！データを受け取りました。",
        "user_name": name,
        "user_age": age,
        "status": "success",
        "processed_info": {
            "timestamp": "2023-10-27T10:30:00Z", # 例としてタイムスタンプ
            "next_birthday_year": 2024 # 例として計算された値
        },
        "errors": []
    }

    # Pythonの辞書をJSON形式の文字列に変換し、標準出力に出力します。
    # ensure_ascii=False は日本語などの非ASCII文字をそのまま出力するために必要です。
    print(json.dumps(result_data, ensure_ascii=False))

if __name__ == "__main__":
    main()