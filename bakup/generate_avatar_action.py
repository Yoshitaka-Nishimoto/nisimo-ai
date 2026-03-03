import os
import base64
from google import genai
from google.genai import types

def main():
    api_key = "AIzaSyCD0hKBx-WMnoqWomCCb13cHTY2YjnwT9Y"
    client = genai.Client(api_key=api_key, http_options={'api_version': 'v1beta'})

    # 画像を読み込み
    input_image_path = "public/imgs/avatar/ownerAvatarFace.jpg"
    if not os.path.exists(input_image_path):
        print(f"Error: {input_image_path} not found.")
        return

    with open(input_image_path, "rb") as f:
        image_bytes = f.read()

    # 1. Gemini 2.0 Flash で画像を分析
    print("Analyzing input image...")
    analysis_prompt = (
        "この画像には1人の男性の4枚の写真が含まれています。彼の顔の特徴（輪郭、目、鼻、口元）と、特に【髪型】について非常に詳しく英語で描写してください。"
        "この描写は、Imagen 4.0で新しい鉛筆スケッチ風アバターを生成するために使用されます。彼を特定できるユニークな特徴、落ち着いた大人の男性としての雰囲気を詳細に記述してください。"
    )
    
    try:
        analysis_response = client.models.generate_content(
            model='gemini-2.0-flash-001',
            contents=[
                types.Part.from_bytes(data=image_bytes, mime_type='image/jpeg'),
                analysis_prompt
            ]
        )
        detailed_description = analysis_response.text
        print("Analysis complete.")
    except Exception as e:
        print(f"Analysis error: {e}")
        return

    # 2. Imagen 4.0 で画像を生成
    # プロンプトの構築（2x2グリッドの4つの顔）
    final_prompt = (
        f"A professional high-quality hand-drawn pencil sketch on slightly textured white paper. "
        f"The image must be a 2x2 grid containing four separate headshot avatars. "
        f"The person in all four avatars is the same man, identical to this description: {detailed_description}. "
        f"Crucially, the hairstyle must be EXTREMELY faithful to the reference (silvery-gray, voluminous, swept to the side). "
        f"Each of the four faces in the grid should have a slightly different calm, mature expression (e.g., neutral, subtle smile, pensive, gentle). "
        f"Masculine, realistic, artistic clean lines, no text, no colors, pure pencil sketching."
    )

    print("Generating 4-face grid image with Imagen 4.0...")
    try:
        response = client.models.generate_images(
            model='imagen-4.0-generate-001',
            prompt=final_prompt,
            config=types.GenerateImagesConfig(
                number_of_images=1,
                aspect_ratio="1:1"
            )
        )
        
        output_path = "public/imgs/avatar/ownerAvatar_v0_20260301_103127.png"
        with open(output_path, "wb") as f:
            f.write(response.generated_images[0].image.image_bytes)
        print(f"Successfully saved and overwritten {output_path}")

    except Exception as e:
        print(f"Image generation error: {e}")

if __name__ == "__main__":
    main()
