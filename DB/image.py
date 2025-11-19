from pathlib import Path
import shutil
import sys
import traceback


def main():
    # ベースディレクトリはこのスクリプトの親ディレクトリ (cooking-AI-php)
    base_dir = Path(__file__).resolve().parent.parent

    # 保存先フォルダ
    save_dir = base_dir / 'image' / '食材'
    save_dir.mkdir(parents=True, exist_ok=True)

    # 元画像ファイル（アップロードされた画像など）
    source_image = base_dir / 'image' / '食材' / '4.png'  # 実際のパスに変更してください
    if not source_image.exists():
        print(f'❌ 元画像が見つかりません: {source_image}')
        return 1

    # 繰り返し回数を指定
    repeat_count = 400

    # 既存ファイル数をカウントして開始番号を決定
    existing_files = [p for p in save_dir.iterdir() if p.name.startswith('image_') and p.suffix.lower() == '.jpg']
    start_index = len(existing_files) + 1

    # 指定回数繰り返して保存
    for i in range(repeat_count):
        filename = f'{start_index + i}.jpg'  # 例: 1.jpg
        destination_path = save_dir / filename
        try:
            shutil.copy(str(source_image), str(destination_path))
            print(f'{filename} を保存しました。')
        except Exception as e:
            print(f'コピー中にエラーが発生しました: {e}')
            traceback.print_exc()
            return 1

    return 0


if __name__ == '__main__':
    rc = main()
    sys.exit(rc)