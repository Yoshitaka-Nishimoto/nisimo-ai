import os
import base64
from google import genai
from google.genai import types
from PIL import Image
import io

def generate():
    client = genai.Client(api_key=os.environ.get("GEMINI_API_KEY"))
    
    # 元画像の読み込み
    with open("public/imgs/avatar/ownerAvatarFace.jpg", "rb") as f:
        image_bytes = f.read()

    prompt = (
        "Create a hand-drawn pencil sketch avatar based on the provided person. "
        "Make it look distinctly male with slightly narrower eyes. "
        "The hairstyle must be EXTREMELY faithful to the original photo. "
        "Simple, masculine, and realistic to the original facial features. "
        "Plain white background."
    )

    # Imagen 3 (or applicable model) with image input
    response = client.models.generate_images(
        model='imagen-3.0-generate-001',
        prompt=prompt,
        config=types.GenerateImagesConfig(
            numberOfImages=1,
        )
        # Note: Depending on SDK version, image-to-image might be handled differently.
        # If this fails, we will try another model that supports multimodal input.
    )

    for i, generated_image in enumerate(response.generated_images):
        output_path = "public/imgs/avatar/ownerAvatar_v4_new.png"
        with open(output_path, "wb") as f:
            f.write(generated_image.image_bytes)
        print(f"Generated: {output_path}")

if __name__ == "__main__":
    generate()
