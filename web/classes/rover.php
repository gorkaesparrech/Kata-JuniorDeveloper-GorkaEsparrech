<?php

use Random\BrokenRandomEngineError;

class Rover{
    public string $direction = '';
    public int $positionX, $positionY, $lastPositionX, $lastPositionY, $directionRand, $obstacleDetectedX, $obstacleDetectedY;
    public bool $obstacle = false;

    public function __construct(){
        $this->positionX = rand(1, 200);
        $this->positionY = rand(1, 200);
        $this->directionRand = rand(1,4);
        if($this->directionRand == 1){
            $this->direction = 'N';
        }
        else if($this->directionRand == 2){
            $this->direction = 'E';
        }
        else if($this->directionRand == 3){
            $this->direction = 'S';
        }
        else{
            $this->direction = 'O';
        }

    }

    public function movement($movementDirection, $obstacleList){
        //Si el movimiento es hacía adelante no realizará ningún cambio en la dirección y efectuará directamente la comprobación
        $this->obstacle = false;
        if($movementDirection == 'F'){
            $this->movementValidation($this->direction, $obstacleList);
        }
        //Si se mueve a derecha o izquierda, revisa la dirección actual y cambia la dirección del Rover antes de moverlo
        else{  
            switch($this->direction){
                case ('N'):
                    if($movementDirection == 'R'){
                        $this->direction = 'E';
                    }
                    else{
                        $this->direction = 'O';
                    }
                    break;
                
                case ('S'):
                    if($movementDirection == 'R'){
                        $this->direction = 'O';
                    }
                    else{
                        $this->direction = 'E';
                    }
                    break;
                
                case ('E'):
                    if($movementDirection == 'R'){
                        $this->direction = 'S';
                    }
                    else{
                        $this->direction = 'N';
                    }
                    break;
                
                case ('O'):
                    if($movementDirection == 'R'){
                        $this->direction = 'N';
                    }
                    else{
                        $this->direction = 'S';
                    }
                    break;
                }
                $this->movementValidation($this->direction, $obstacleList);
        }
    }

    //Validación del movimiento hacía delante
    public function movementValidation(string $actualDirection, $obstacles){
        $this->lastPositionX = $this->positionX;
        $this->lastPositionY = $this->positionY;

        if($actualDirection == 'N'){
            $this->positionX++;
        }
        else if($actualDirection == 'S'){
            $this->positionX--;
        }
        else if($actualDirection == 'E'){
            $this->positionY++;
        }
        else if($actualDirection == 'O'){
            $this->positionY--;
        }

        //Revisa que no se tope con ningún obstaculo
        foreach($obstacles->obstacleArray as $obstacle){
            if($this->positionX == $obstacle->positionX){
                if($this->positionY == $obstacle->positionY){
                    $this->obstacleDetectedX = $this->positionX;
                    $this->obstacleDetectedY = $this->positionY;
                    $this->positionX = $this->lastPositionX;
                    $this->positionY = $this->lastPositionY;
                    $this->obstacle = true;
                }
            }
        }
        //Revisa que no salga de los límites del mundo de 200x200
        if($this->positionX>200 || $this->positionX<1){
            $this->obstacleDetectedX = $this->positionX;
                    $this->obstacleDetectedY = $this->positionY;
                    $this->positionX = $this->lastPositionX;
                    $this->positionY = $this->lastPositionY;
                    $this->obstacle = true;
        }
        if($this->positionY>200 || $this->positionY<1){
            $this->obstacleDetectedX = $this->positionX;
                    $this->obstacleDetectedY = $this->positionY;
                    $this->positionX = $this->lastPositionX;
                    $this->positionY = $this->lastPositionY;
                    $this->obstacle = true;
        }
    }
}

?>