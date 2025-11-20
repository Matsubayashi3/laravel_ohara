import google.generativeai as genai
from PIL import Image
import io
import os

# APIキー設定
genai.configure(api_key="AIzaSyD4vBXreTog5iqkPJ8Q35hk3ONTRi3HoBs")

# モデル指定
model = genai.GenerativeModel("gemini-2.5-flash-image")

# プロンプト
prompt = "野菜の画像を生成してください。"

# 保存先ディレクトリを指定
save_dir = "C:/xampp/htdocs/php/cooking-AI-php/image/recipe"
os.makedirs(save_dir, exist_ok=True)  # フォルダがなければ作成

# 生成リクエスト
response = model.generate_content(prompt)

# parts から画像を取り出して保存
for i, part in enumerate(response.parts):
    if part.inline_data:  # 画像データがある場合
        img = Image.open(io.BytesIO(part.inline_data.data))
        file_path = os.path.join(save_dir, f"vegetable_{i}.png")
        img.save(file_path)
        print(f"✅ 画像を保存しました: {file_path}")
    elif part.text:  # テキスト応答が返ってきた場合
        print("テキスト応答:", part.text)