#if defined(ESP32)
  #include <WiFiMulti.h>
  WiFiMulti wifiMulti;
  #define DEVICE "ESP32"
#elif defined(ESP8266)
  #include <ESP8266WiFiMulti.h>
  ESP8266WiFiMulti wifiMulti;
  #define DEVICE "ESP8266"
#endif

#include <Wire.h>
#include <Adafruit_ADS1X15.h>
#include <InfluxDbClient.h>
#include <InfluxDbCloud.h>

#define WIFI_SSID "MK"
#define WIFI_PASSWORD "BlackStar"

#define INFLUXDB_URL "http://127.0.0.1:8086"
#define INFLUXDB_TOKEN "bxeo4qAyxr6SqUbTfrWxJ_lppUGIJ0bUtyenw9wgeR2xiDy0fyYXDLKjuFGrCsB1ZY7XD1U9twkuZvFCAvUu8g=="
#define INFLUXDB_ORG "64039cd4068c2546"
#define INFLUXDB_BUCKET "BacketBase"

#define TZ_INFO "America/Santiago"

InfluxDBClient client(INFLUXDB_URL, INFLUXDB_ORG, INFLUXDB_BUCKET, INFLUXDB_TOKEN, InfluxDbCloud2CACert);

Point sensor("Aceleración");

Adafruit_ADS1115 ads;

void setup() {
  Serial.begin(115200);

  Wire.begin();
  if (!ads.begin()) {
    Serial.println("Failed to initialize ADS1115. Check your connections.");
    while (1);
  }
  Serial.println("ADS1115 initialized.");

  // Setup WiFi
  WiFi.mode(WIFI_STA);
  wifiMulti.addAP(WIFI_SSID, WIFI_PASSWORD);

  Serial.print("Connecting to WiFi");
  while (wifiMulti.run() != WL_CONNECTED) {
    Serial.print(".");
    delay(100);
  }
  Serial.println("\nWiFi connected.");

  timeSync(TZ_INFO, "pool.ntp.org", "time.nis.gov");
  if (client.validateConnection()) {
    Serial.print("Connected to InfluxDB: ");
    Serial.println(client.getServerUrl());
  } else {
    Serial.print("InfluxDB connection failed: ");
    Serial.println(client.getLastErrorMessage());
  }
}

void loop() {
  int16_t adc0 = ads.readADC_SingleEnded(0);
  int16_t adc1 = ads.readADC_SingleEnded(1);
  int16_t adc2 = ads.readADC_SingleEnded(2);

  float voltage0 = adc0 * 0.1875 / 1000; 
  float voltage1 = adc1 * 0.1875 / 1000; 
  float voltage2 = adc2 * 0.1875 / 1000; 

  sensor.clearFields();

  sensor.addField("channel_0", voltage0);
  sensor.addField("channel_1", voltage1);
  sensor.addField("channel_2", voltage2);
  sensor.addField("rssi", WiFi.RSSI());

  Serial.print("Writing: ");
  Serial.println(sensor.toLineProtocol());

  if (wifiMulti.run() != WL_CONNECTED) {
    Serial.println("WiFi connection lost. Reconnecting...");
  }

  if (!client.writePoint(sensor)) {
    Serial.print("InfluxDB write failed: ");
    Serial.println(client.getLastErrorMessage());
  }

  delay(500);
}
