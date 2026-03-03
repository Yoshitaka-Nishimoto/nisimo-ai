import os
import base64
from google import genai
from google.genai import types

def main():
    api_key = "AIzaSyCD0hKBx-WMnoqWomCCb13cHTY2YjnwT9Y"
    # v1 (デフォルト) を使用
    client = genai.Client(api_key=api_key)

    # 画像を読み込み
    input_image_path = "public/imgs/avatar/ownerAvatarFace.jpg"
    with open(input_image_path, "rb") as f:
        image_bytes = f.read()

    # 1. リストの先頭にあった gemini-2.5-flash を使用
    print("Analyzing input image with gemini-2.5-flash...")
    analysis_prompt = (
        "Analyze this image containing four photos of a man. "
        "Describe his face and hairstyle in detail for image generation. "
        "He is a mature, calm man with silvery-gray hair."
    )
    
    try:
        analysis_response = client.models.generate_content(
            model='gemini-2.5-flash',
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

    # 2. リストにあった imagen-4.0-generate-001 を使用
    final_prompt = (
        f"A professional high-quality hand-drawn pencil sketch 2x2 grid of four avatars of the same man. "
        f"Description: {detailed_description}. "
        f"Maintain the hairstyle exactly. Four different calm expressions. "
        f"Pencil sketch on white paper."
    )

    print("Generating image with imagen-4.0-generate-001...")
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
        print(f"Successfully saved to {output_path}")

    except Exception as e:
        print(f"Image generation error: {e}")

if __name__ == "__main__":
    main()
