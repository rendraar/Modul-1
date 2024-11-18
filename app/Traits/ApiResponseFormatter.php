<?php

namespace app\Traits;

trait ApiResponseFormatter {
    public function apiResponse($code, $message, $data = null) {
        // Konversi menjadi JSON dan kirimkan dengan header Content-Type
        header('Content-Type: application/json');
        echo json_encode([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
        exit; // Pastikan skrip PHP berhenti di sini
    }
}
