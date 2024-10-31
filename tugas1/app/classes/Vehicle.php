<?php
namespace App\Classes;

use App\Traits\IdentifiableTrait;

abstract class Vehicle {
    use IdentifiableTrait;

    protected $name;
    protected $speed;

    public function __construct($name, $speed) {
        $this->name = $name;
        $this->speed = $speed;
    }

    public function getName() {
        return $this->name;
    }

    public function getSpeed() {
        return $this->speed;
    }

    abstract public function description();
}
?>