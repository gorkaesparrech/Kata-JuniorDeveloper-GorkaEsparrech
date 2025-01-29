<?php

class Obstacle{
        public $positionX, $positionY;

        //Genera la posición aleatoria del obstaculo dentro del mundo de 200x200
        public function __construct()
        {
            $this->positionX = rand(1, 200);
            $this->positionY = rand(1, 200);
        }
}
?>