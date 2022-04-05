<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmarTask</title>
    <link rel="stylesheet" href="./opening.css">
</head>

<body>
    
        <nav id="navbar">
            <!-- <div id="logo">
                <img src="" alt="">
            </div> -->
            <ul>
                <li class="item"><a href="#">Home</a></li>
                <li class="item"><a href="#">Features</a></li>
                <li class="item"><a href="#">How To Use</a></li>
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
            <h2>"Experience the ease of compliting task"</h2>
        </section>
    </section>

    <section class="feature-container">
        <h1 class="h-primary center">Features</h1>
        <div id="features" class="features">
            <div class="box">
                <img src="./Images/note.jpg" alt="img for notes ">
                <button class="show">Notes</button>
                <h2 id=hide></h2>
            </div>
            <div class="box">
                <img src="./Images/calender.jpg" alt="img for calender ">
                <button class="show">Notes</button>
                <h2 id=hide>This feature helps you to note down all the</h2>
            </div>
            <div class="box">
                <img src=" ./Images/bell.jpg" alt=" img for notification ">
                <button class="show">Notes</button>
                <h2 id=hide></h2>
            </div>
            <div class="box">
                <img src=" ./Images/bell.jpg" alt=" img for notification ">
                <button class="show">Notes</button>
                <h2 id=hide></h2>
            </div>
            <div class="box">
                <img src=" ./Images/bell.jpg" alt=" img for notification ">
                <button class="show">Notes</button>
                <h2 id=hide></h2>
            </div>
        </div>
    </section>

    <section class="use" id="use">
        <h1 class="h-primary center">How To Use</h1>
        <div class="use-container">
            <div class="use-containt">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam magnam possimus fuga ducimus, atque nemo quas esse nulla eaque alias amet illum quam consequuntur ut odit eius veniam voluptate pariatur.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam magnam possimus fuga ducimus, atque nemo quas esse nulla eaque alias amet illum quam consequuntur ut odit eius veniam voluptate pariatur.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam magnam possimus fuga ducimus, atque nemo quas esse nulla eaque alias amet illum quam consequuntur ut odit eius veniam voluptate pariatur.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam magnam possimus fuga ducimus, atque nemo quas esse nulla eaque alias amet illum quam consequuntur ut odit eius veniam voluptate pariatur.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam magnam possimus fuga ducimus, atque nemo quas esse nulla eaque alias amet illum quam consequuntur ut odit eius veniam voluptate pariatur.</p>
            </div>
    </section>
    <section>
        <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
    </section>
</body>

<script src="./Script/opening.js"></script>
</html>