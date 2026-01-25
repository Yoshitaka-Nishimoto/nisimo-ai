#!/bin/bash

# スクリプトにファイルパスが渡されているかチェック
if [ -z "$1" ]; then
    echo "エラー: 対象となるファイルのパスを指定してください。"
    echo "使用法: $0 <ファイルパス>"
    exit 1
fi

TARGET_FILE="$1"

# ファイルが存在するかどうかをチェック
if [ ! -f "$TARGET_FILE" ]; then
    echo "エラー: ファイルが見つかりません: $TARGET_FILE"
    exit 1
fi

# ファイルの行数を確認
line_count=$(wc -l < "$TARGET_FILE")
if [ "$line_count" -le 23 ]; then # 18 + 5 = 23
    echo "エラー: ファイルの行数が少なく、処理できません（23行以下）。"
    exit 1
fi

# 安全な一時ファイルを作成
TMP_FILE=$(mktemp)

# 最初の18行と最後の5行を削除し、テキストの幅を85文字に整形して、
# マークダウンのコードブロック内に書き込む
{
    echo '```text'
    tail -n +19 "$TARGET_FILE" | head -n -5 | fmt -w 85
    echo
    echo '```'
} > "$TMP_FILE"

# 元のファイルを、処理後の一時ファイルで置き換える
mv "$TMP_FILE" "$TARGET_FILE"

echo "ログファイルを整形しました: $TARGET_FILE"