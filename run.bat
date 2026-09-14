@echo off
echo ===================================================
echo   EcoSense Multi-Node Monitoring Hub
echo   Unified Dashboard: Soil, Water, and Weather
echo ===================================================
echo.

if not exist .env (
    echo [INFO] Menduplikasi .env.example menjadi .env...
    copy .env.example .env
)

if not exist database\database.sqlite (
    echo [INFO] Membuat database SQLite...
    type nul > database\database.sqlite
)

echo [INFO] Menjalankan key:generate jika belum ada...
php artisan key:generate --force

echo [INFO] Menjalankan migrasi database dan seeder data sensor...
php artisan migrate --seed --force

echo.
echo ===================================================
echo   Server berjalan di http://127.0.0.1:8000
echo   - Portal Hub       : http://127.0.0.1:8000
echo   - Dashboard Tanah  : http://127.0.0.1:8000/soil
echo   - Dashboard Air    : http://127.0.0.1:8000/water
echo   - Dashboard Cuaca  : http://127.0.0.1:8000/weather
echo ===================================================
echo Tekan Ctrl+C untuk menghentikan server.
echo.

php artisan serve --port=8000
pause
