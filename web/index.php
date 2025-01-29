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
    <link rel="stylesheet" href="classes\styles\styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1>Rover Control</h1>
        <hr>
        <form method="POST">
            <button class="controlButtons" type="submit" name="fButton">Forward</button>
            <button class="controlButtons" type="submit" name="rButton">Right</button>
            <button class="controlButtons" type="submit" name="lButton">Left</button>
            <br>
            <button class="controlButtons" type="submit" name="reset">RESET</button>
        </form>
        <div>
            <h2>Rover Status</h2>
            <hr>
            <div class="data">
                <p>Direction: <strong> <?php echo $activeRover->direction ?> </strong> </p>
                <p>Position: <strong> <?php echo $activeRover->positionX ?>, <?php echo $activeRover->positionY ?> </strong> </p>
            </div>
        </div>
        <br>
        <?php
        if($activeRover->obstacle){
            ?>
            <div class="alert data">
                <?php
                echo 'OBSTACLE DETECTED IN: '. $activeRover->obstacleDetectedX .', '. $activeRover->obstacleDetectedY;
                ?>
            <br>
                <?
                echo 'RETURNING TO: '.$activeRover->lastPositionX .', '. $activeRover->lastPositionY;
                ?>
            </div>
            <?php
        }
        else{
            ?>
            <div class="data">
                <?php
                echo 'NO OBSTACLES DETECTED.';
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>