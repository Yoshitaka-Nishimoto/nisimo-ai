import os
import requests
import json
import base64

API_KEY = os.environ.get("GEMINI_API_KEY")
URL = f"https://generativelanguage.googleapis.com/v1beta/models/imagen-3.0-generate-001:predict?key={API_KEY}"

def generate():
    # 元画像を読み込んでBase64エンコード（必要であれば）
    # ただし、Imagen 3は現在テキストプロンプトからの生成がメインなので、
    # プロンプトで詳細に指示を出します。
    
    prompt = (
        "A realistic hand-drawn pencil sketch of a middle-aged Japanese man. "
        "The eyes are slightly narrow and masculine. "
        "The hairstyle is a natural, slightly voluminous salt-and-pepper hair, "
        "highly faithful to a typical realistic portrait. "
        "Simple, masculine, and dignified look. Plain white background. "
        "Single portrait focused on the face."
    )

    payload = {
        "instances": [
            {
                "prompt": prompt
            }
        ],
        "parameters": {
            "sampleCount": 1,
            "aspectRatio": "1:1"
        }
    }

    response = requests.post(URL, json=payload)
    
    if response.status_code == 200:
        data = response.json()
        # 画像データを取り出す
        img_b64 = data['predictions'][0]['bytesBase64Encoded']
        with open("public/imgs/avatar/ownerAvatar_v4_new.png", "wb") as f:
            f.write(base64.b64decode(img_b64))
        print("Successfully generated: public/imgs/avatar/ownerAvatar_v4_new.png")
    else:
        print(f"Error: {response.status_code}")
        print(response.text)

if __name__ == "__main__":
    generate()
