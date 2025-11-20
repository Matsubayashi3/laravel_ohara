import google.generativeai as genai
from PIL import Image

# APIキー設定
genai.configure(api_key="AIzaSyD4vBXreTog5iqkPJ8Q35hk3ONTRi3HoBs")

# モデルを直接指定
model = genai.GenerativeModel("gemini-2.5-flash-image")

# プロンプト
prompt = "野菜の画像を生成してください。"

# 生成リクエスト
response = model.generate_content(prompt)

# 返り値の処理
for part in response.parts:
    if part.text:
        print(part.text)
    elif part.inline_data:
        image = part.as_image()
        image.save("generated_image.png")