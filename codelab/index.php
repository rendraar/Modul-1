<?php

include "controllers/productController.php";

use controller\productController;

$productController = new productController;

echo $productController -> getAllProduct();