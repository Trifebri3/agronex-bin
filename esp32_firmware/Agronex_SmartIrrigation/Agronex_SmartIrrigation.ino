#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h> // pastikan sudah menginstal pustaka ArduinoJson v6

// --- KONFIGURASI WIFI & API ---
const char* ssid = "NAMA_WIFI";
const char* password = "PASSWORD_WIFI";
const char* device_id = "AGR-001";
const char* api_url_base = "http://YOUR_LARAVEL_IP:8000/api/v1/devices/";

// --- KONFIGURASI PIN ---
const int SOIL_MOISTURE_PIN = 34; // Pin analog untuk sensor tanah
const int RELAY_PIN = 26;         // Pin digital untuk relay pompa (Active High/Low tergantung modul)

// --- VARIABEL STATE ---
String currentMode = "AUTO_SENSOR";
float thresholdOn = 35.0;
float thresholdOff = 50.0;
float targetMoisture = 60.0;
int maxWateringDuration = 300; // detik
int cooldownMinutes = 10;
String manualCommand = "NONE";

float currentMoisture = 0.0;
bool isPumpOn = false;
unsigned long pumpStartedAt = 0;
unsigned long lastTelemetryTime = 0;
unsigned long lastConfigCheckTime = 0;

void setup() {
  Serial.begin(115200);
  pinMode(RELAY_PIN, OUTPUT);
  digitalWrite(RELAY_PIN, LOW); // Pompa mati
  
  WiFi.begin(ssid, password);
  Serial.print("Menghubungkan ke WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWiFi terhubung!");
}

void loop() {
  if (WiFi.status() != WL_CONNECTED) {
    // Jika WiFi putus, matikan pompa untuk keamanan
    if(isPumpOn) turnPumpOff("WIFI_DISCONNECTED");
    return;
  }

  // Baca Sensor
  int rawAnalog = analogRead(SOIL_MOISTURE_PIN);
  // Asumsi: 4095 = 0% (kering), 0 = 100% (basah penuh). Kalibrasi sesuai sensor Anda.
  currentMoisture = map(rawAnalog, 4095, 0, 0, 100);
  if(currentMoisture < 0) currentMoisture = 0;
  if(currentMoisture > 100) currentMoisture = 100;

  unsigned long currentMillis = millis();

  // 1. Ambil Konfigurasi dari Web Admin (Setiap 10 Detik)
  if (currentMillis - lastConfigCheckTime >= 10000) {
    lastConfigCheckTime = currentMillis;
    fetchConfig();
  }

  // 2. Logic Smart Irrigation
  handleIrrigationLogic();

  // 3. Kirim Telemetri (Setiap 30 detik)
  if (currentMillis - lastTelemetryTime >= 30000) {
    lastTelemetryTime = currentMillis;
    sendTelemetry();
  }

  delay(1000); // Loop delay
}

void handleIrrigationLogic() {
  // Pengecekan Safety (Max Watering Duration)
  if (isPumpOn) {
    unsigned long duration = (millis() - pumpStartedAt) / 1000;
    if (duration >= maxWateringDuration) {
      turnPumpOff("MAX_DURATION_REACHED");
      return;
    }
  }

  // MANUAL COMMAND OVERRIDE
  if (manualCommand == "PUMP_ON" && !isPumpOn) {
    turnPumpOn("MANUAL");
    manualCommand = "NONE";
    return;
  } else if (manualCommand == "PUMP_OFF" && isPumpOn) {
    turnPumpOff("MANUAL");
    manualCommand = "NONE";
    return;
  }

  // AUTO SENSOR (Hysteresis)
  if (currentMode == "AUTO_SENSOR") {
    if (currentMoisture < thresholdOn && !isPumpOn) {
      turnPumpOn("AUTO");
    } else if (currentMoisture >= thresholdOff && isPumpOn) {
      turnPumpOff("AUTO");
    }
  }
  // AUTO TARGET (Jaga di target)
  else if (currentMode == "AUTO_TARGET") {
    if (currentMoisture < (targetMoisture - 5) && !isPumpOn) {
      turnPumpOn("AUTO");
    } else if (currentMoisture >= targetMoisture && isPumpOn) {
      turnPumpOff("AUTO");
    }
  }
}

void turnPumpOn(String trigger) {
  digitalWrite(RELAY_PIN, HIGH); // Nyalakan relay
  isPumpOn = true;
  pumpStartedAt = millis();
  Serial.println("POMPA ON via " + trigger);
}

void turnPumpOff(String trigger) {
  digitalWrite(RELAY_PIN, LOW); // Matikan relay
  isPumpOn = false;
  unsigned long duration = (millis() - pumpStartedAt) / 1000;
  Serial.println("POMPA OFF via " + trigger);
  
  sendEvent(trigger, duration); // Catat kejadian di database
}

void fetchConfig() {
  HTTPClient http;
  String url = String(api_url_base) + String(device_id) + "/config";
  http.begin(url);
  int httpCode = http.GET();
  
  if (httpCode == 200) {
    String payload = http.getString();
    StaticJsonDocument<512> doc;
    DeserializationError error = deserializeJson(doc, payload);
    
    if (!error) {
      currentMode = doc["config"]["mode"].as<String>();
      thresholdOn = doc["config"]["threshold_on"];
      thresholdOff = doc["config"]["threshold_off"];
      targetMoisture = doc["config"]["target_moisture"];
      maxWateringDuration = doc["config"]["max_watering_duration"];
      cooldownMinutes = doc["config"]["cooldown_minutes"];
      
      String cmd = doc["command"].as<String>();
      if(cmd != "NONE") manualCommand = cmd;
    }
  }
  http.end();
}

void sendTelemetry() {
  HTTPClient http;
  String url = String(api_url_base) + String(device_id) + "/telemetry";
  http.begin(url);
  http.addHeader("Content-Type", "application/json");

  StaticJsonDocument<200> doc;
  doc["soil_moisture"] = currentMoisture;
  doc["pump_status"] = isPumpOn;

  String requestBody;
  serializeJson(doc, requestBody);
  http.POST(requestBody);
  http.end();
}

void sendEvent(String trigger, int duration) {
  HTTPClient http;
  String url = String(api_url_base) + String(device_id) + "/events";
  http.begin(url);
  http.addHeader("Content-Type", "application/json");

  StaticJsonDocument<200> doc;
  doc["trigger_type"] = trigger;
  doc["duration_seconds"] = duration;
  doc["moisture_after"] = currentMoisture; // Asumsi after

  String requestBody;
  serializeJson(doc, requestBody);
  http.POST(requestBody);
  http.end();
}
