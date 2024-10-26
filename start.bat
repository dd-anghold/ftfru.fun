@echo off

start "Server" cmd /k "npm run dev"
start "Server" cmd /k "php artisan serve --host=localhost --port=80"
start "Redis Server" "redis-server"
