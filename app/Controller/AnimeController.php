<?php

namespace app\Controller;

include_once __DIR__ . '/../Traits/ApiResponseFormatter.php';
include_once __DIR__ . '/../Models/Anime.php';

use app\Models\Anime;
use app\Traits\ApiResponseFormatter;

class AnimeController {

    use ApiResponseFormatter;

    public function index()
    {
        header("Access-Control-Allow-Origin: *");  // Mengizinkan akses dari semua domain
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  // Mengizinkan beberapa metode HTTP
        header("Access-Control-Allow-Headers: Content-Type");  // Mengizinkan header Content-Type

        // DEFINISI OBJEK MODEL Anime YANG SUDAH DIBUAT
        $AnimeModel = new Anime();
        $response = $AnimeModel->findAll();
        // RESPONSE DENGAN MELAKUKAN FORMATTING TERLEBIH DAHULU MENGGUNAKAN TRAIT YANG SUDAH DIPANGGIL
        return $this->apiResponse(200, "success", $response);
    }

    public function getById($id)
    {
        $AnimeModel = new Anime();
        $response = $AnimeModel->findById($id);
        return $this->apiResponse(200, "success", $response);
    }

    public function insert() {
        // TANGGAP INPUT JSON
        $jsonInput = file_get_contents("php://input");
        $inputData = json_decode($jsonInput, true);
    
        // VALIDASI INPUT VALID ATAU TIDAK
        if (json_last_error() || empty($inputData['anime_name']) || empty($inputData['type']) || empty($inputData['status']) || empty($inputData['image_url'])) {
            return $this->apiResponse(400, "Error: invalid input", null);
        }
    
        $AnimeModel = new Anime();
        $response = $AnimeModel->create([
            "anime_name" => $inputData["anime_name"],
            "type" => $inputData["type"],
            "status" => $inputData["status"],
            "image_url" => $inputData["image_url"]
        ]);
    
        if ($response['success']) {
            return $this->apiResponse(200, "Anime created successfully", ["id" => $response["id"]]);
        } else {
            return $this->apiResponse(500, "Error creating Anime", ["error" => $response["error"]]);
        }
    }
    

    public function update($id)
    {
        $jsonInput = file_get_contents("php://input");
        $inputData = json_decode($jsonInput, true);
        if (json_last_error()) {
            return $this->apiResponse(400, "Error invalid input", null);
        }

        $AnimeModel = new Anime();
        $AnimeModel->update([
            "anime_name" => $inputData["anime_name"],
            "type" => $inputData["type"],
            "status" => $inputData["status"],
            "image_url" => $inputData["image_url"]
        ], $id);

        return $this->apiResponse(200, "success", null);
    }

    public function delete($id) {
        $AnimeModel = new Anime();
        $response = $AnimeModel->delete($id);
    
        if ($response['success']) {
            return $this->apiResponse(200, $response['message'], null);
        } else {
            return $this->apiResponse(404, $response['message'], null);
        }
    }
    
}
