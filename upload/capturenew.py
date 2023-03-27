import os
import docx
import PyPDF2
import nltk
from nltk.corpus import stopwords
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import mysql.connector

# Set up NLTK stopwords
nltk.download('stopwords', quiet=True)
nltk.download('punkt', quiet=True)
stop_words = list(stopwords.words('english'))

# Function to convert PDF to plain text
def pdf2txt(file_path):
    with open(file_path, 'rb') as f:
        pdf_reader = PyPDF2.PdfReader(f)
        num_pages = len(pdf_reader.pages)

        text = ""
        for i in range(num_pages):
            page = pdf_reader.pages[i]
            text += page.extract_text()

        return text

# Function to convert DOCX to plain text
def docx2txt(file_path):
    document = docx.Document(file_path)
    text = ""
    for paragraph in document.paragraphs:
        text += paragraph.text

    return text

# Function to extract plain text from all files in directory
def extract_text():
    for file_name in os.listdir('.'):
        if file_name.endswith('.pdf') and not file_name.startswith('~$'):
            file_path = os.path.abspath(file_name)
            text = pdf2txt(file_path)
            txt_path = os.path.join(str("readyForSum")+'.txt')
            with open(txt_path, 'w', encoding='utf-8') as f:
                f.write(text)
            os.remove(file_name)
        elif file_name.endswith('.docx') and not file_name.startswith('~$'):
            file_path = os.path.abspath(file_name)
            text = docx2txt(file_path)
            txt_path = os.path.join(str("readyForSum")+'.txt')
            with open(txt_path, 'w', encoding='utf-8') as f:
                f.write(text)
            os.remove(file_name)

# Function to generate summary
def generate_summary():
    # Extract text from files
    extract_text()

    # Read text from file
    with open('readyForSum.txt', 'r') as f:
        text = f.read()

    # Tokenize sentences
    sentences = nltk.sent_tokenize(text)

    # Create TF-IDF matrix
    vectorizer = TfidfVectorizer(stop_words=stop_words)
    tfidf_matrix = vectorizer.fit_transform(sentences)

    # Calculate similarity matrix
    sim_matrix = cosine_similarity(tfidf_matrix, tfidf_matrix)

    # Generate summary
    summary = ""
    ranked_sentences = sorted(((sim_matrix[i][j], i, j) for i in range(len(sentences)) for j in range(len(sentences)) if i != j), reverse=True)
    for i in range(min(len(sentences), 5)):
        index = ranked_sentences[i][1]
        summary += sentences[index] + " "

    # Print summary
    print("Summarize Text: \n", summary)

    # Connect to MySQL database
    mydb = mysql.connector.connect(
      host="localhost",
      user="xunidb",
      password="xunistudygo",
      database="xunidb",
      charset="utf8"
    )
    
    mycursor = mydb.cursor()
    
    # Define SQL query to update abstract field
    sql = "UPDATE document SET abstract = %s WHERE id = (SELECT MAX(ids) FROM (SELECT id as ids FROM document) AS temabs)"
    val = summary
    
    # Try to execute query and commit changes to database
    mycursor.execute(sql, (val,))
    mydb.commit()
    
    # Close database connection
    mycursor.close()
    mydb.close()
    
    return summary

# filename = 'validate.txt'
# if not os.path.exists(filename):
#     with open(filename, 'w') as f:
#         f.write('Filesdasasd created')
generate_summary()


