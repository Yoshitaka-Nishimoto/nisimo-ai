import os
import google.generativeai as genai

genai.configure(api_key=os.environ.get("GEMINI_API_KEY"))

def generate():
    # Imagenモデルを指定（利用可能な名前を確認）
    # 通常、GenerativeModel('imagen-3.0-generate-001') など
    try:
        model = genai.GenerativeModel('gemini-1.5-flash')
        # 画像を読み込み
        with open("public/imgs/avatar/ownerAvatarFace.jpg", "rb") as f:
            img_data = f.read()
        
        # 1.5 Flashで画像を分析し、最高のプロンプトを作成する（バックアップ）
        # 本来はImagenを直接呼び出したいが、制限がある場合はこちらで詳細な指示を出す
        
        prompt = (
           "Generate four hand-drawn, pencil-sketched avatars based on the attached photos."
           "Make the eyes more masculine."
           "Stay as close to the original photo as possible with the hairstyle."
           "Focus on a simple, masculine, and realistic look."
           "Output image bytes if possible (use imagen integration if possible)."
        )
        
        # ※現在のgoogle-generativeai SDKではImagenの直接生成は一部制限があるため
        # 内部ツールが使えない状況では、APIを直接叩くのが確実です。
        print("Starting generation via API...")
    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    generate()
