<?php
/*
 * Скопируйте этот файл в config.php и впишите реальные данные.
 * Файл config.php добавлен в .gitignore и НЕ попадёт в репозиторий.
 * Значения можно задавать через переменные окружения или прямо здесь.
 */

define('DB_HOST', getenv('DB_HOST') ?: 'localhost:3306');
define('DB_USER', getenv('DB_USER') ?: 'your_db_user');
define('DB_PASS', getenv('DB_PASS') ?: 'your_db_password');
define('DB_NAME', getenv('DB_NAME') ?: 'your_db_name');

// Секретный ключ для script.php (API-доступ к БД)
define('SQL_KEY', getenv('SQL_KEY') ?: 'change_me');
