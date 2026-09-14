# 🌐 EcoSense - Unified Multi-Node Monitoring Hub
> **All-in-One Environmental & Agriculture Telemetry System (Soil, Water, Weather)**

Aplikasi ini menyatukan 3 sistem dashboard monitoring yang sebelumnya terpisah menjadi **satu platform terpadu yang siap di-deploy dalam sekali jalan** (Single Deployment). Dilengkapi dengan Landing Portal berbasis kartu seleksi interaktif, navigasi terintegrasi antar dashboard, pembaruan data real-time, dan endpoint REST API lengkap untuk sensor IoT.

---

## 🚀 Fitur Utama

1. **Satu Kali Deploy (Single Deployment)**:
   - Cukup jalankan 1 service web Laravel dan 1 database untuk memantau ketiga jenis node sensor.
   - Siap deploy di VPS, Hosting cPanel/Plesk, Docker, Render, Railway, ataupun Fly.io.

2. **Landing Page Hub Interaktif (`/`)**:
   - 3 Interactive Selection Cards untuk **Tanah (Soil)**, **Kualitas Air (Water)**, dan **Stasiun Cuaca (Weather)**.
   - Live KPI Preview: Nilai parameter terkini dan status node langsung terlihat di halaman depan sebelum masuk ke detail dashboard.
   - System Health Indicator & Live Polling.

3. **Top Navigation Switcher**:
   - Tombol switcher pada setiap dashboard memungkinkan perpindahan instan antar node (Hub ⇄ Tanah ⇄ Air ⇄ Cuaca) tanpa perlu membuka tab baru atau bolak-balik.

4. **Dashboard Lengkap & Telemetri Real-Time**:
   - **🌱 Soil Monitoring (`/soil`)**: Kelembapan, Suhu Tanah, pH Tanah, Nilai EC, Nitrogen (N), Fosfor (P), Kalium (K), dan Total NPK.
   - **💧 Water Quality (`/water`)**: Derajat Keasaman (pH), Suhu Air, Padatan Terlarut (TDS), dan Kekeruhan (Turbidity) dengan evaluasi status kelayakan air otomatis.
   - **🌤️ Weather Station (`/weather`)**: Suhu Udara, Kelembapan Relatif, Kecepatan Angin, Curah Hujan, Tekanan Udara (Barometer), Intensitas Cahaya (Lux), Titik Embun (Dew Point), dan Evapotranspirasi Acuan (ET0).

5. **Tool Simulasi IoT Bawaan**:
   - Tombol uji coba langsung di halaman Hub dan masing-masing Dashboard untuk meng-generate data sensor secara instan tanpa memerlukan perangkat keras mikrokontroler.

6. **REST API Siap Pakai untuk Mikrokontroler**:
   - Kompatibel dengan ESP32, ESP8266, Arduino, LoRaWAN Node, dan Raspberry Pi.

---

## ⚡ Cara Menjalankan di Lokal (Windows)

### Cara Cepat (1-Klik):
Cukup klik dua kali file **`run.bat`** di direktori ini! Skrip ini otomatis:
- Menyalin `.env.example` ke `.env`
- Membuat database SQLite
- Melakukan migrasi dan seeding data awal realistis
- Menjalankan server di `http://127.0.0.1:8000`

### Cara Manual lewat Terminal:
```bash
# 1. Masuk ke direktori
cd "c:\Dashboard combination 3 data"

# 2. Install dependencies (jika belum)
composer install

# 3. Setup environment & database
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed

# 4. Jalankan server
php artisan serve
```

Buka browser di:
- **Landing Hub**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Dashboard Tanah**: [http://127.0.0.1:8000/soil](http://127.0.0.1:8000/soil)
- **Dashboard Air**: [http://127.0.0.1:8000/water](http://127.0.0.1:8000/water)
- **Dashboard Cuaca**: [http://127.0.0.1:8000/weather](http://127.0.0.1:8000/weather)

---

## 🐳 Cara Deploy dengan Docker

Aplikasi ini sudah dilengkapi dengan `Dockerfile` dan `docker-compose.yml`:
```bash
docker compose up -d --build
```
Aplikasi akan langsung online di port `8000` dengan persistensi database SQLite di folder `./database`.

---

## 📡 Dokumentasi Endpoint REST API IoT

### 1. Sensor Tanah (Soil Data)
- **Endpoint**: `POST /api/soil-data`
- **Headers**: `Content-Type: application/json`
- **Payload**:
```json
{
  "kelembapan": 62.5,
  "suhu": 27.8,
  "ec": 750,
  "ph": 6.85,
  "nitrogen": 55,
  "fosfor": 32,
  "kalium": 140
}
```
- **Ambil Data Terkini**: `GET /api/soil-data/latest`
- **Ambil Riwayat**: `GET /api/soil-data/history`

### 2. Sensor Kualitas Air (Water Data)
- **Endpoint**: `POST /api/water-data`
- **Headers**: `Content-Type: application/json`
- **Payload**:
```json
{
  "suhu": 27.10,
  "ph": 7.35,
  "tds": 245.0,
  "turbidity": 6.2
}
```
- **Ambil Data Terkini**: `GET /api/water-data/latest`

### 3. Sensor Stasiun Cuaca (Weather Data)
- **Endpoint**: `POST /api/weather-data`
- **Headers**: `Content-Type: application/json`
- **Payload**:
```json
{
  "suhu": 29.4,
  "kelembapan": 70.2,
  "tekanan": 1012.8,
  "cahaya": 45000,
  "kecepatan_angin": 3.6,
  "curah_hujan": 0,
  "dew_point": 23.4,
  "et0": 4.2
}
```
- **Ambil Data Terkini**: `GET /api/weather-data/latest`
- **Ambil Riwayat**: `GET /api/weather-data/history`

---

## 📁 Struktur Direktori Terpadu

```
├── app/
│   ├── Http/Controllers/
│   │   ├── HubController.php              # Controller Landing Portal & Simulator
│   │   ├── SoilDashboardController.php    # Controller Web Dashboard Tanah
│   │   ├── SoilDataController.php         # API Controller Sensor Tanah
│   │   ├── WaterDashboardController.php   # Controller Web Dashboard Air
│   │   ├── WaterDataController.php        # API Controller Sensor Air
│   │   ├── WeatherDashboardController.php # Controller Web Dashboard Cuaca
│   │   └── WeatherDataController.php      # API Controller Sensor Cuaca
│   └── Models/
│       ├── SoilData.php
│       ├── WaterData.php
│       └── WeatherData.php
├── database/
│   ├── migrations/
│   └── seeders/DatabaseSeeder.php
├── resources/views/
│   ├── hub/index.blade.php                # Landing Hub dengan Card Seleksi
│   ├── soil/dashboard.blade.php           # Dashboard Tanah
│   ├── water/dashboard.blade.php          # Dashboard Air
│   └── weather/dashboard.blade.php        # Dashboard Cuaca
├── routes/
│   ├── web.php                            # Web Routes
│   └── api.php                            # IoT Sensor API Routes
├── run.bat                                # Windows 1-Click Runner
├── Dockerfile & docker-compose.yml        # Production Container Deployment
└── README.md
```
# agronex-bin
