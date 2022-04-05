<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmarTask</title>
    <link rel="stylesheet" href="./Style/opening.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<body>
        <nav id="navbar">
            <!-- <div id="logo">
                <img src="" alt="">
            </div> -->
            <ul id="nav-elements">
                <li class="item"><a href="#home">Home</a></li>
                <li class="item"><a href="#nfeature">Features</a></li>
                <li class="item"><a href="#nuse">How To Use</a></li>
                <?php
                if (!isset($_SESSION['email'])) {
                ?>
                <li class="item"><a href="signup.php">Log In</a></li>
                <li class="item"><a href="pmsignup.php">PM Login</a></li>
                
                <?php
                }else{
                ?>
                <li class="item"><a href="projects.php">Projects</a></li>
                <li class="item"><a href="logout.php">logout</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    
    <section class="bg">
        <section class="heading" id="heading">
            <h1>Managing task was never this easy before.</h1>
            <h2>"Experience the ease of completing Project"</h2>
            <p id="btn" class="btn"> Lets get started </p>
            <img class="bg_image" src="./Images/work4.png" alt=" ">
        </section>
    </section>

    <section class="feature-container scrollspy">
        <h1 class="h-primary center">Features</h1>
        <div id="features" class="features">
            <div class="box">
                <img src="./Images/notes.png" alt="img for notes ">
                <h1>Assign Tas</h1>
                <h2 id=hide> This feature allows project manager to create and assign task to team members </h2>
            </div>
            <div class="box">
                <img src="./Images/calender.png" alt="img for calender ">
                <h1>Calander</h1>
                <h2 id=hide>This feature helps you to assigne date to all your task so you complete all in good time</h2>
            </div>
            <div class="box">
                <img src=" ./Images/bell.png" alt=" img for notification ">
                <h1>Notification</h1>
                <h2 id=hide>This feature notifies you few hour prior to submit your work/task</h2>
            </div>
        </div>
    </section>
    <section class="use">
        <h1 class="h-primary center">How To Use</h1>
        <div class="use-container">
            <div class="use-containt">
                <p>1. Project manager will create a project</p>
                <p>2. Task will be assigned to the user/ or user can also create task</p>
                <p>3. Assign deadline to the task in calander</p>
                <p>4. SmarTask will notify you 24hr before the assigned time </p>
                <p>5. After submission task is successfully completed</p>
            </div>
            <div class="taskName" id="task">
                <img src="./Images/bulb.png" alt="">
                <img class="dis" src="./Images/assign.png" alt="">
                <img class="dis" src="./Images/time.png" alt="">
                <img src="./Images/alarm.png" alt="">
                <img src="./Images/tick.png" alt="">
            </div>
            <div class="taskBar">
                <p></p>
            </div>
    </section>
    <!-- <section>
        <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
    </section> -->
</body>
<script src="./Script/opening.js"></script>
</html>