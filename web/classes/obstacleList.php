<?php
require_once('classes\obstacle.php');

class ObstacleList{
    public int $obstacleMaxNumber = 30;
    public array $obstacleArray = [];
    public function __construct($activeRover){

        //Genera 30 obstaculos dentro del mundo
        for($i = 0; $i<$this->obstacleMaxNumber; $i++){
            $newObstacle = new Obstacle;
            //En caso de que un obstaculo no pueda generarse en su ubicación no se añadirá a la lista y se volverá a crear.
            if($this->validateNewPosition($newObstacle, $activeRover)){
                $i--;
            }
            else{
                array_push($this->obstacleArray, $newObstacle);
            }
        }
    }

    //Asegura que la posición en la que se coloca el obstaculo no exista ya un obstaculo o sea la posición inicial del Rover.
    public function validateNewPosition($obstacleToValidate, $activeRover){
        foreach($this->obstacleArray as $obstacle){

            if($activeRover->positionX == $obstacle->positionX){
                if($activeRover->positionY == $obstacle->positionY){
                    return true;
                }
            }
            if($obstacleToValidate->positionX == $obstacle->positionX){
                if($obstacleToValidate->positionY == $obstacle->positionY){
                    return true;
                }
            }
        }
    }
}
?>