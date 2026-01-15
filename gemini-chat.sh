#!/bin/bash

# スクリプトが引数なしで実行された場合に使い方を表示
if [ -z "$1" ]; then
    echo "使用法: $0 <ファイル名>"
    exit 1
fi

# 保存先ディレクトリ
TARGET_DIR="/mnt/windows_share/app/01pinpon_log/"

# 保存先ディレクトリが存在しない場合は作成
mkdir -p "$TARGET_DIR"

# 現在の日時を取得 (YYYY-MM-DD_HH_MM_SS)
TIMESTAMP=$(date +"%Y-%m-%d_%H_%M_%S")

# 新しいファイル名を作成
NEW_FILENAME="chat_log${TIMESTAMP}.md"

# コピー元のファイルパス
SOURCE_FILE="$1"

# 保存先のフルパス
DESTINATION_PATH="${TARGET_DIR}${NEW_FILENAME}"

# ファイルをコピー
cp "$SOURCE_FILE" "$DESTINATION_PATH"

echo "ファイルを ${DESTINATION_PATH} に保存しました。"
