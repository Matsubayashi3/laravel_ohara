import os
import shutil

# 保存先フォルダ
save_dir = 'images'
os.makedirs(save_dir, exist_ok=True)

# 元画像ファイル（アップロードされた画像など）
source_image = 'uploaded/cabbage.jpg'  # 実際のパスに変更してください

# 繰り返し回数を指定
repeat_count = 400

# 既存ファイル数をカウントして開始番号を決定
existing_files = [f for f in os.listdir(save_dir) if f.startswith('image_') and f.endswith('.jpg')]
start_index = len(existing_files) + 1

# 指定回数繰り返して保存
for i in range(repeat_count):
    filename = f'image_{start_index + i:03}.jpg'  # 例: image_005.jpg
    destination_path = os.path.join(save_dir, filename)
    shutil.copy(source_image, destination_path)
    print(f'{filename} を保存しました。')