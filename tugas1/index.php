<?php
require_once 'app/interfaces/Driveable.php';
require_once 'app/traits/IdentifiableTrait.php';
require_once 'app/classes/Vehicle.php';
require_once 'app/classes/Car.php';

use App\Classes\Car;

// Membuat objek mobil
$car = new Car("Toyota Supra", 280, "Petrol");
$car->setId(1);

// Menampilkan informasi mobil
echo "Car ID: " . $car->getId() . PHP_EOL;
echo $car->startEngine() . PHP_EOL;
echo $car->description() . PHP_EOL;
echo $car->stopEngine();
?>