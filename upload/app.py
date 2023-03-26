from flask import Flask, render_template_string
import capturenew

app = Flask(__name__)

@app.route('/api')
def index():
    # Call generate_summary function from capturenew module
    # summary = capturenew.generate_summary()
    
    # # Render HTML template and pass summary to the frontend
    # return render_template_string('<p>{{ summary }}</p>', summary=summary)
    
    return 'helloworld'

if __name__ == '__main__':
    print('running!!!')
    app.run(debug=True)
