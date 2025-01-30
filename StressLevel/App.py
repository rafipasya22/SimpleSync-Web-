from flask import Flask, Response
import mysql.connector
import joblib
import numpy as np

app = Flask(__name__)

model = joblib.load('modelSCA2.pkl')

db_config = {
    'user': 'root',
    'password': '',
    'host': 'localhost',
    'database': 'sensor_data',
    'raise_on_warnings': True
}

def get_data_from_db():
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor()
    query = "SELECT id, rmssd, lf_power, hf_power, lf_hf_ratio, vlf_power, vlf_pct, lf_pct, hf_pct FROM sensor_readings ORDER BY id DESC LIMIT 1"
    cursor.execute(query)
    result = cursor.fetchone()  
    cursor.close()
    conn.close()
    return result 

def save_prediction_to_db(prediction, row_id):
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor()
    query = "UPDATE sensor_readings SET predict = %s WHERE id = %s"
    cursor.execute(query, (prediction, row_id))  
    conn.commit()
    cursor.close()
    conn.close()

@app.route('/')
@app.route('/predict-and-save', methods=['GET'])
def predict_and_save():
    data_row = get_data_from_db()
    if data_row:
        row_id = data_row[0]
        input_data = np.array(data_row[1:]).reshape(1, -1)
        
        prediction = model.predict(input_data)[0]
        
        save_prediction_to_db(prediction, row_id)
        
        return Response(status=204);
    else:
        return Response("Tidak ada data yang ditemukan.", status=404);

if __name__ == '__main__':
    app.run(debug=True)