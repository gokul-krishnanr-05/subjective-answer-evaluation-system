import sys
import spacy
from scipy.spatial.distance import cosine

# Load the spaCy model with word vectors (you may need to download this model: python -m spacy download en_core_web_md)
nlp = spacy.load("en_core_web_md")

def get_sentence_embedding(text):
    # Tokenize and get the average of word vectors for the sentence
    tokens = nlp(text)
    return tokens.vector

def calculate_similarity(text1, text2):
    # Get sentence embeddings
    embedding1 = get_sentence_embedding(text1)
    embedding2 = get_sentence_embedding(text2)

    # Calculate cosine similarity between the embeddings
    similarity_score = 1 - cosine(embedding1, embedding2)

    # Convert the similarity score to a percentage
    similarity_percentage = round(similarity_score * 100, 2)

    return similarity_percentage

if __name__ == "__main__":
    # Get text1 and text2 from command-line arguments
    text1 = sys.argv[1]
    text2 = sys.argv[2]
    # Calculate similarity
    similarity_percentage = calculate_similarity(text1, text2)
    
    # Print the result to be captured by PHP
    print(similarity_percentage)
