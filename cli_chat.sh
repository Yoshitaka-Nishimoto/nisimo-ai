#!/bin/bash

# --- cli_chat.sh ---
# gemini-chat.sh と format-log.sh の機能を統合したスクリプト

# --- 引数のチェック ---
if [ -z "$1" ]; then
    echo "エラー: 対象となるファイルのパスを指定してください。"
    echo "使用法: $0 <ファイルパス>"
    exit 1
fi

SOURCE_FILE="$1"

# ソースファイルが存在するかチェック
if [ ! -f "$SOURCE_FILE" ]; then
    echo "エラー: ファイルが見つかりません: $SOURCE_FILE"
    exit 1
fi

# --- 処理 1: ファイルのコピー (gemini-chat.sh) ---

# 保存先ディレクトリ
TARGET_DIR="/mnt/windows_share/app/01pinpon_log/"

# 保存先ディレクトリが存在しない場合は作成
mkdir -p "$TARGET_DIR"

# 現在の日時を取得 (YYYY-MM-DD_HH_MM_SS)
TIMESTAMP=$(date +"%Y-%m-%d_%H_%M_%S")

# 新しいファイル名を作成
NEW_FILENAME="chat_log${TIMESTAMP}.md"

# 保存先のフルパス
DESTINATION_PATH="${TARGET_DIR}${NEW_FILENAME}"

# ファイルをコピー
cp "$SOURCE_FILE" "$DESTINATION_PATH"

echo "ファイルを ${DESTINATION_PATH} に保存しました。"


# --- 処理 2: コピーしたファイルの整形 (format-log.sh) ---

# コピーしたファイルの行数を確認
line_count=$(wc -l < "$DESTINATION_PATH")
if [ "$line_count" -le 23 ]; then # 18 + 5 = 23
    echo "警告: ファイルの行数が23行以下のため、整形処理はスキップしました。"
    exit 0
fi

# 安全な一時ファイルを作成
TMP_FILE=$(mktemp)

# 最初の18行と最後の5行を削除し、テキストの幅を85文字に整形して、
# マークダウンのコードブロック内に書き込む
{
    echo '```text'
    tail -n +19 "$DESTINATION_PATH" | head -n -5 | fmt -w 85
    echo
    echo '```'
} > "$TMP_FILE"

# 元のファイルを、処理後の一時ファイルで置き換える
mv "$TMP_FILE" "$DESTINATION_PATH"

echo "ログファイルを整形しました: $DESTINATION_PATH"
