<?php

namespace controller;

include "traits/responseFormatter.php";
include "controllers/controller.php";

use traits\ResponseFormatter;

class productController extends controller{
    use ResponseFormatter;

    public function __construct()
    {
        $this->controllerName = "Get All Product";
        $this->controllerMethod = "GET";
    }

    public function getAllProduct(){
        $dummyData = [
            "Air Mineral",
            "Kebab",
            "Spaghetti",
            "Jus Jambu",
        ];

        $response = [
            "controller_attribute" => $this->getControllerAttribute(),
            "product" => $dummyData
        ];

        return $this->responseFormatter(200, "Succcess", $response);
    }
}