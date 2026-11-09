# extract_script.py
import pytesseract as pyt
import cv2
import sys

pyt.pytesseract.tesseract_cmd = "C:\\Program Files\\Tesseract-OCR\\tesseract.exe"

# Define a function to extract text from an image
def extract_text_from_image(image_path):
    img = cv2.imread(image_path)
    text = pyt.image_to_string(img)
    print(text)

# Check if a command-line argument is provided (file path)
if len(sys.argv) > 1:
    image_path = sys.argv[1]
    extract_text_from_image(image_path)
