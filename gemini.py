import httpx
import base64
import google.generativeai as genai
import traceback

try:
    genai.configure(api_key="AIzaSyD5eSZoK_qCu6vgsmybbqmlMRqpcea62Ds")

    model = genai.GenerativeModel("gemini-2.5-flash")

    image_url = "https://osaka-ainou.jp/images/convert/osaka-ainoujp/20240718082815.jpg/image.webp"
    # print(f"画像を取得中: {image_url}")
    # Wikipedia は user-agent を要求しているため、ヘッダーを追加
    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
    }
    response_img = httpx.get(image_url, headers=headers, timeout=30.0)

    # 画像取得成功か確認
    if response_img.status_code == 200:
        # print(f"✅ 画像取得成功 ({len(response_img.content)} bytes)")
        image_data = base64.b64encode(response_img.content).decode("utf-8")
        prompt = """画像の食材の個数を教えてください返り値は以下の例でお願いします。
        返り値を配列として登録するのを想定していますので、以下の形式のみで出力すること。
        ['キャベツ',1],['にんじん',2],['たまねぎ',16]
        """

        # print("Gemini API に送信中...")
        response = model.generate_content([
            {'mime_type': 'image/jpeg', 'data': image_data},
            prompt
        ])
        # print("✅ レスポンス取得成功")
        print(response.text)
    else:
        print(f"❌ 画像の取得に失敗しました。ステータスコード: {response_img.status_code}")
        print(f"レスポンス本文: {response_img.text[:300]}")

except httpx.HTTPError as e:
    print(f"❌ HTTP エラー: {e}")
    traceback.print_exc()
except Exception as e:
    print(f"❌ エラー発生: {type(e).__name__}: {e}")
    traceback.print_exc()
    
# import base64
# import google.generativeai as genai
# import traceback

# try:
#     genai.configure(api_key="YOUR_API_KEY")
#     model = genai.GenerativeModel("gemini-2.5-flash")

#     # ローカル画像ファイルのパス
#     image_path = "C:/xampp/htdocs/php/cooking-AI-php/image/食材/4.png"
#     with open(image_path, "rb") as f:
#         image_bytes = f.read()
#     image_data = base64.b64encode(image_bytes).decode("utf-8")

#     prompt = "この画像はどこで撮影されたものだと考えられる？"
#     response = model.generate_content([
#         {'mime_type': 'image/png', 'data': image_data},
#         prompt
#     ])
#     print(response.text)

# except Exception as e:
#     print(f"❌ エラー発生: {type(e).__name__}: {e}")
#     traceback.print_exc()