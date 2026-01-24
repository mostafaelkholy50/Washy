@echo off
echo Clearing all cache...
cd /d "d:\vipp\Admin dashboard"
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
echo.
echo Cache cleared successfully!
echo.
echo Now open: http://127.0.0.1:8000
echo For English: http://127.0.0.1:8000/?lang=en
echo For Arabic: http://127.0.0.1:8000/?lang=ar
echo.
pause
