import influxdb_client
import time
import random
from influxdb_client import Point
from influxdb_client.client.write_api import SYNCHRONOUS

# Configuración de conexión
token = "8O-ON6ULAnfweh8gad3UpePFY6ICmbKLvMCExxrS2vCs4s0s25A9fpCTKIBULHvADbP3OHR3mA6Gmo1LMaEgXQ=="
org = "MKDevelopment"
url = "http://127.0.0.1:8086"
bucket = "BacketBase"

# Cliente de InfluxDB
client = influxdb_client.InfluxDBClient(url=url, token=token, org=org)
write_api = client.write_api(write_options=SYNCHRONOUS)

# Parámetros de vibración
base_range = 1.0  # Rango base de vibración ±1g
peak_probability = 0.1  # Probabilidad de un pico mayor a ±1g
step_time = 1  # Intervalo entre mediciones en segundos

try:
    # Bucle infinito hasta que se interrumpa con Ctrl+C
    while True:
        # Generar un valor aleatorio de vibración
        if random.random() < peak_probability:
            # Generar un pico eventual
            vibration = round(random.uniform(-3.0, 3.0), 2)  # Picos entre ±3g
        else:
            # Valor normal dentro del rango base
            vibration = round(random.uniform(-base_range, base_range), 2)
        
        # Crear el punto de datos
        point = (
            Point("Vibration")
            .tag("location", "A02-1")
            .tag("sensor", "ADXL-A02-3")
            .field("g", vibration)  # Usar el valor generado
        )
        
        # Escribir el punto en InfluxDB
        write_api.write(bucket=bucket, org=org, record=point)
        print(f"Dato enviado: {vibration} g")
        
        # Esperar el intervalo definido
        time.sleep(step_time)
except KeyboardInterrupt:
    print("\nPrograma detenido por el usuario.")
finally:
    client.close()
