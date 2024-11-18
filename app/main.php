<?php
// File: C:\xampp\htdocs\app\main.php
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . "/Routes/AnimeRoutes.php"; // Adjust the path if necessary

use app\Routes\AnimeRoutes;

if (isset($_SERVER['REQUEST_METHOD']) && isset($_SERVER['REQUEST_URI'])) {
    $method = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $productRoutes = new AnimeRoutes();
    $productRoutes->handle($method, $path);
} else {
    echo "Script harus dijalankan melalui server web.";
}
