<?php
namespace App\Classes;

use App\Interfaces\Driveable;

class Car extends Vehicle implements Driveable {
    private $fuelType;

    public function __construct($name, $speed, $fuelType) {
        parent::__construct($name, $speed);
        $this->fuelType = $fuelType;
    }

    public function startEngine() {
        return "{$this->name} engine started.";
    }

    public function stopEngine() {
        return "{$this->name} engine stopped.";
    }

    public function description() {
        return "The {$this->name} car has a top speed of {$this->speed} km/h and runs on {$this->fuelType}.";
    }
}
?>