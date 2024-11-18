<?php

namespace app\Routes;

include_once __DIR__ . '/../Controller/AnimeController.php'; // Adjust the path

use app\Controller\AnimeController;

class AnimeRoutes
{
    public function handle($method, $path)
    {
        if ($method == "GET" && $path == "/api/anime") {
            $controller = new AnimeController();
            echo $controller->index();
        }

        if ($method == "GET" && strpos($path, "/api/anime/") === 0) {
            $pathParts = explode("/", $path);
            $id = $pathParts[count($pathParts) - 1];

            $controller = new AnimeController();
            echo $controller->getById($id);
        }

        if ($method == "POST" && strpos($path, "/api/anime/") === 0) {
            $controller = new AnimeController();
            echo $controller->insert();
        }

        if ($method == "PUT" && strpos($path, "/api/anime/") === 0) {
            $pathParts = explode("/", $path); 
            $id = $pathParts[count($pathParts) - 1];

            $controller = new AnimeController();
            echo $controller->update($id);
        }

        if ($method == "DELETE" && strpos($path, "/api/anime/") === 0) {
            $pathParts = explode("/", $path);
            $id = $pathParts[count($pathParts) - 1];

            $controller = new AnimeController();
            echo $controller->delete($id);
        }
    }
}
