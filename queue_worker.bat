@echo off
cd /d C:\xampp\htdocs\Concurrency
start /B php artisan queue:work --tries=3 --timeout=0
