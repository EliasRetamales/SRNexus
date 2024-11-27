import influxdb_client
import time
from influxdb_client import Point
from influxdb_client.client.write_api import SYNCHRONOUS

# Configuración de conexión
token = "8O-ON6ULAnfweh8gad3UpePFY6ICmbKLvMCExxrS2vCs4s0s25A9fpCTKIBULHvADbP3OHR3mA6Gmo1LMaEgXQ=="
org = "MKDevelopment"
url = "http://127.0.0.1:8086"
bucket = "BacketBase"

client = influxdb_client.InfluxDBClient(url=url, token=token, org=org)
write_api = client.write_api(write_options=SYNCHRONOUS)

# Parámetros del diente de sierra
min_temp = 150  # Temperatura mínima
max_temp = 250  # Temperatura máxima
cycle_time = 10 * 60  # Ciclo completo en segundos (30 minutos)
step_time = 1  # Intervalo entre mediciones en segundos
step = (max_temp - min_temp) / (cycle_time / step_time)  # Incremento por paso

try:
    temp = min_temp
    increasing = True
    # Bucle infinito hasta que se interrumpa con Ctrl+C
    while True:
        point = (
            Point("Temperature")
            .tag("location", "S21-A")
            .tag("sensor","PT100-S21-A")
            .field("C", round(float(temp), 2))
        )
        
        write_api.write(bucket=bucket, org=org, record=point)
        print(f"Dato enviado: {round(float(temp), 2)} °C")
        
        if increasing:
            temp += step
            if temp >= max_temp:
                temp = max_temp
                increasing = False
        else:
            temp -= step
            if temp <= min_temp:
                temp = min_temp
                increasing = True
        
        time.sleep(step_time)
except KeyboardInterrupt:
    print("\nPrograma detenido por el usuario.")
finally:
    client.close()
