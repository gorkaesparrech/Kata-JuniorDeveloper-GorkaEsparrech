<?php
require_once('classes\rover.php');
require_once('classes\obstacleList.php');

//Aquí se inicía una sesión para guardar la posición del rover y de los obstaculos
session_start();
    if(!isset($_SESSION['activeRover'])){

        $activeRover = new Rover;
        $activeObstacles = new ObstacleList($activeRover);

        $_SESSION['activeRover'] = $activeRover;
        $_SESSION['activeObstacles'] = $activeObstacles;
    }
    else{
        $activeRover = $_SESSION['activeRover'];
        $activeObstacles = $_SESSION['activeObstacles'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['fButton'])){
            $activeRover->movement('F', $activeObstacles); 
        } 
        else if(isset($_POST['rButton'])){
            $activeRover->movement('R', $activeObstacles);
        } 
        else if(isset($_POST['lButton'])){
            $activeRover->movement('L', $activeObstacles);
        }
        else if(isset($_POST['reset'])){
            header("Location:".$_SERVER['PHP_SELF']);
            session_destroy();
            exit();
        }
    }
    else{
        $_SESSION['activeRover'] = $activeRover;
        $_SESSION['activeObstacles'] = $activeObstacles;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Rover Control</h2>
    <form method="POST">
        <button type="submit" name="fButton">Forward</button>
        <button type="submit" name="rButton">Right</button>
        <button type="submit" name="lButton">Left</button>
        <br>
        <button type="submit" name="reset">RESET</button>
    </form>
    <h2>Rover Status</h2>
    <p>Direction: <?php echo $activeRover->direction ?> </p>
    <p>Position: <?php echo $activeRover->positionX ?>, <?php echo $activeRover->positionY ?> </p>
    <br>
    <?php
    if($activeRover->obstacle){
        echo 'OBSTACLE DETECTED IN: '. $activeRover->obstacleDetectedX .', '. $activeRover->obstacleDetectedY;
        ?><br><?
        echo 'RETURNING TO: '.$activeRover->lastPositionX .', '. $activeRover->lastPositionY;
    }
    else{
        echo 'NO OBSTACLES DETECTED.';
    }
    ?>
</body>
</html>