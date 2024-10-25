<?php

namespace controller;

class controller{
    var $controllerName;
    var $controllerMethod;

    public function getControllerAttribute(){
        return [
            "ControllerName" => $this->controllerName,
            "Method" => $this->controllerMethod,
        ];
    }
}