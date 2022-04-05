<?php
    session_start();
    include 'connection.php';
    $pid=$_SESSION["projectid"];
    if(!isset($_SESSION["projectid"])){
        header("location: projects.php");
    }
    $email = $_SESSION['email'];
    if($_SESSION['usertype']=="PM"){
        $query1 = "SELECT * FROM `projectmanagers` WHERE `Email`='$email'";
        $result1 = mysqli_query($conn,$query1);
        if(mysqli_num_rows($result1)==0){
            header("location: logout.php");
        }else{
            $row1 = mysqli_fetch_assoc($result1);
            $uid = $row1["PID"];
        }
    }else{
        $query1 = "SELECT `sno`, `name`, `email`, `password` FROM `users` WHERE `email`='$email'";
        $result1 = mysqli_query($conn,$query1);
        if(mysqli_num_rows($result1)==0){
            header("location: logout.php");
        }else{
            $row1 = mysqli_fetch_assoc($result1);
            $uid = $row1["sno"];
        }
           
    }
    if (isset($_POST["next"])){
        $index = $_POST['index'];
        $query = "SELECT * FROM `Task` WHERE `TaskID` = '$index'";
        $result = mysqli_query($conn,$query);
        $row=mysqli_fetch_row($result);
        if($row[4]==3){
            
        }else{
            $finals =$row[4]+1; 
            
            $query1 = "UPDATE Task SET status='$finals' WHERE `TaskID`='$index'";
            
            $result1 = mysqli_query($conn,$query1);
            
        }
        



    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <style>
    .adduserbtn{
        display: block;
        font-size: 20px;
        color: white;
        padding: 10px 0;
        width: 90%;
        margin: 10px auto;
        background: var(--main-color);
        font-weight: bold;
    }
    .adduserbtn p{
        text-align:center;
    }
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .close:hover,
        .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
        }
        .profile{
            margin-right:20px;
        }
        .disable{
            background: #999;
            color:#fff;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">
        <div class="logo">KONTRI</div>
        </a>
        <div class="right">
            <div class="profile"></div>
          
        </div>
        
    </div>
    <div class="content">
        <div class="sidebar">
            <div class="teamtoggle">
                <div class="toggle" onclick="openCity(event, 'todo')">Me</div>
                <div class="toggle" onclick="openCity(event, 'kanban')">Team</div>
            </div>
            
        </div>
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>Some text in the Modal..</p>
            </div>

        </div>
        <div class="container">
            <div id="kanban" class="tab">
                <div class="status">
                    <div class="header">
                        <p>ASSIGNED</p>
                        <div class="remain">1</div>
                        <div class="addbtn">+</div>
                    </div>
                    <?php
                   
                        $query = "SELECT * FROM `Task` WHERE `status` = 0";
                        $result = mysqli_query($conn,$query);
                        
                        while($rows=mysqli_fetch_assoc($result)){
                          $taskid= $rows["TaskID"];
                          $query1 = "SELECT * FROM `projecttask` WHERE `ProjectID` = '$pid' AND `TaskID`='$taskid'";
                            $result1 = mysqli_query($conn,$query1);
                            if(mysqli_num_rows($result1)>0){
                        
                    ?>
                    <form method="post" action="addtask.php">
                    <div class="task">
                    <div class="tasktitle">
                            <p><?php echo $rows['TaskName']; ?></p>
                        </div>
                        <div class="taskdesc">
                            <p><?php echo $rows['TaskDesc']; ?></p>
                        </div>
                        <div class="assigned">
                            <?php

                                $query8 = "SELECT * FROM `usertask` WHERE `TaskID` = '$taskid'";
                                $result8 = mysqli_query($conn,$query8);

                                $row8=mysqli_fetch_assoc($result8);
                                $user = $row8['sno'];
                                $query8 = "SELECT * FROM `users` WHERE `sno` = '$user'";
                                $result9 = mysqli_query($conn,$query8);

                                $row9=mysqli_fetch_assoc($result9);
                            
                                $name= ucfirst($row9["name"]);
                                $userletter = substr($name, 0, 1);

                            ?>
                            <div class="person"><?php echo $userletter;?>
                            <span class="tooltiptext"><?php echo $name;?></span>
                        </div>
                            
                        </div>
                        <input type="hidden" value="<?php echo $rows['TaskID'];?>" name="index"/>
                        <?php
                        if($_SESSION['email']==$row9['email']){
                        ?>
                        <input type="submit" value = "Next Stage >" class="statusbtn" name="next"/>
                        <?php
                        }else{
                        ?>
                        <input type="submit" value = "Next Stage >" class="statusbtn disable" name="next" disabled/>

                        <?php
                        }
                        ?>
                        
                        
                    </div>
                    </form>
                    <?php
                     }   
                    }
                    ?>
                </div>
    
    
    
                <div class="status">
                    <div class="header">
                        <p>IN PROGRESS</p>
                        <div class="remain">2</div>
                        <div class="addbtn">+</div>
                    </div>
                    <?php
                   
                        $query = "SELECT * FROM `Task` WHERE `status` = 1";
                        $result = mysqli_query($conn,$query);
                        while($rows=mysqli_fetch_assoc($result)){
                            $taskid= $rows["TaskID"];
                            $query1 = "SELECT * FROM `projecttask` WHERE `ProjectID` = '$pid' AND `TaskID`='$taskid'";
                              $result1 = mysqli_query($conn,$query1);
                              if(mysqli_num_rows($result1)>0){
                        
                    ?>
                   <form method="post" action="addtask.php">
                    <div class="task">
                    <div class="tasktitle">
                            <p><?php echo $rows['TaskName']; ?></p>
                        </div>
                        <div class="taskdesc">
                            <p><?php echo $rows['TaskDesc']; ?></p>
                        </div>
                        
                        <div class="assigned">
                            <?php

                                $query8 = "SELECT * FROM `usertask` WHERE `TaskID` = '$taskid'";
                                $result8 = mysqli_query($conn,$query8);

                                $row8=mysqli_fetch_assoc($result8);
                                $user = $row8['sno'];
                                $query8 = "SELECT * FROM `users` WHERE `sno` = '$user'";
                                $result9 = mysqli_query($conn,$query8);

                                $row9=mysqli_fetch_assoc($result9);
                            
                                $name= ucfirst($row9["name"]);
                                $userletter = substr($name, 0, 1);

                            ?>
                            <div class="person"><?php echo $userletter;?>
                            <span class="tooltiptext"><?php echo $name;?></span>
                        </div>
                        </div>
                        <input type="hidden" value="<?php echo $rows['TaskID'];?>" name="index"/>
                        <?php
                        if($_SESSION['email']==$row9['email']){
                        ?>
                        <input type="submit" value = "Next Stage >" class="statusbtn" name="next"/>
                        <?php
                        }else{
                        ?>
                        <input type="submit" value = "Next Stage >" class="statusbtn disable" name="next" disabled/>

                        <?php
                        }
                        ?>
                    </div>
                    </form>
                    <?php
                        }
                    }
                    ?>
                    
                </div>
    
    
    
                <div class="status">
                    <div class="header">
                        <p>Completed</p>
                        <div class="remain">4</div>
                        <div class="addbtn">+</div>
                    </div>
                    <?php
                   
                        $query = "SELECT * FROM `Task` WHERE `status` = 2";
                        $result = mysqli_query($conn,$query);
                        while($rows=mysqli_fetch_assoc($result)){
                            $taskid= $rows["TaskID"];
                            $query1 = "SELECT * FROM `projecttask` WHERE `ProjectID` = '$pid' AND `TaskID`='$taskid'";
                              $result1 = mysqli_query($conn,$query1);
                              if(mysqli_num_rows($result1)>0){
                        
                    ?>
                   <form method="post" action="addtask.php">
                    <div class="task">
                    <div class="tasktitle">
                            <p><?php echo $rows['TaskName']; ?></p>
                        </div>
                        <div class="taskdesc">
                            <p><?php echo $rows['TaskDesc']; ?></p>
                        </div>
                        
                        <div class="assigned">
                            <?php

                                $query8 = "SELECT * FROM `usertask` WHERE `TaskID` = '$taskid'";
                                $result8 = mysqli_query($conn,$query8);

                                $row8=mysqli_fetch_assoc($result8);
                                $user = $row8['sno'];
                                $query8 = "SELECT * FROM `users` WHERE `sno` = '$user'";
                                $result9 = mysqli_query($conn,$query8);

                                $row9=mysqli_fetch_assoc($result9);
                            
                                $name= ucfirst($row9["name"]);
                                $userletter = substr($name, 0, 1);

                            ?>
                            <div class="person"><?php echo $userletter;?>
                            <span class="tooltiptext"><?php echo $name;?></span>
                        </div>
                        </div>
                        <input type="hidden" value="<?php echo $rows['TaskID'];?>" name="index"/>
                        <?php
                        if($_SESSION['email']==$row9['email']){
                        ?>
                        <input type="submit" value = "Next Stage >" class="statusbtn" name="next"/>
                        <?php
                        }else{
                        ?>
                        <input type="submit" value = "Next Stage >" class="statusbtn disable" name="next" disabled/>

                        <?php
                        }
                        ?>
                        
                        
                    </div>
                    </form>
                    <?php
                              }  
                    }
                    ?>
                </div>
    
    
    
                <div class="status">
                    <div class="header">
                        <p>REVIEW</p>
                        <div class="remain">2</div>
                        <div class="addbtn">+</div>
                    </div>
                    <?php
                   
                        $query = "SELECT * FROM `Task` WHERE `status` = 3";
                        $result = mysqli_query($conn,$query);
                        while($rows=mysqli_fetch_assoc($result)){
                            $taskid= $rows["TaskID"];
                            $query1 = "SELECT * FROM `projecttask` WHERE `ProjectID` = '$pid' AND `TaskID`='$taskid'";
                              $result1 = mysqli_query($conn,$query1);
                              if(mysqli_num_rows($result1)>0){
                        
                    ?>
                    <div class="task">
                    <div class="tasktitle">
                            <p><?php echo $rows['TaskName']; ?></p>
                        </div>
                        <div class="taskdesc">
                            <p><?php echo $rows['TaskDesc']; ?></p>
                        </div>
                        
                        <div class="assigned">
                            <?php

                                $query8 = "SELECT * FROM `usertask` WHERE `TaskID` = '$taskid'";
                                $result8 = mysqli_query($conn,$query8);

                                $row8=mysqli_fetch_assoc($result8);
                                $user = $row8['sno'];
                                $query8 = "SELECT * FROM `users` WHERE `sno` = '$user'";
                                $result9 = mysqli_query($conn,$query8);

                                $row9=mysqli_fetch_assoc($result9);
                            
                                $name= ucfirst($row9["name"]);
                                $userletter = substr($name, 0, 1);

                            ?>
                            <div class="person"><?php echo $userletter;?>
                            <span class="tooltiptext"><?php echo $name;?></span>
                        </div>
                        </div>
                        
                        <div class="statusbtn disable">Next Stage > </div>
                    </div>
                    <?php
                              }
                    }
                    ?>
                </div>
            </div>

            <div id="todo" class="tab">
            <div class="status">
                    <div class="header">
                        <p>ASSIGNED</p>
                        <div class="remain">1</div>
                        <div class="addbtn">+</div>
                    </div>
                    <?php
                   
                        $query = "SELECT * FROM `Task` WHERE `status` = 0";
                        $result = mysqli_query($conn,$query);
                        
                        while($rows=mysqli_fetch_assoc($result)){
                          $taskid= $rows["TaskID"];
                          $query1 = "SELECT * FROM `projecttask` WHERE `ProjectID` = '$pid' AND `TaskID`='$taskid'";
                            $result1 = mysqli_query($conn,$query1);
                            if(mysqli_num_rows($result1)>0){
                                $query4 = "SELECT * FROM `usertask` WHERE `sno` = '$uid' AND `TaskID`='$taskid'";
                                $result4 = mysqli_query($conn,$query4);
                                if(mysqli_num_rows($result4)>0){
                        
                    ?>
                    <form method="post" action="addtask.php">
                    <div class="task">
                        <div class="taskdesc">
                            <p><?php echo $rows['TaskName']; ?></p>
                        </div>
                        
                        <div class="assigned">
                            <?php

                                $query8 = "SELECT * FROM `usertask` WHERE `TaskID` = '$taskid'";
                                $result8 = mysqli_query($conn,$query8);

                                $row8=mysqli_fetch_assoc($result8);
                                $user = $row8['sno'];
                                $query8 = "SELECT * FROM `users` WHERE `sno` = '$user'";
                                $result9 = mysqli_query($conn,$query8);

                                $row9=mysqli_fetch_assoc($result9);
                            
                                $name= ucfirst($row9["name"]);
                                $userletter = substr($name, 0, 1);

                            ?>
                            <div class="person"><?php echo $userletter;?>
                            <span class="tooltiptext"><?php echo $name;?></span>
                        </div>
                            
                        </div>
                        <input type="hidden" value="<?php echo $rows['TaskID'];?>" name="index"/>
                        <input type="submit" value = "Next Stage >" class="statusbtn" name="next"/>
                        
                        
                    </div>
                    </form>
                    <?php
                     }   
                    }}
                    ?>
                </div>
    
    
    
                <div class="status">
                    <div class="header">
                        <p>IN PROGRESS</p>
                        <div class="remain">2</div>
                        <div class="addbtn">+</div>
                    </div>
                    <?php
                   
                        $query = "SELECT * FROM `Task` WHERE `status` = 1";
                        $result = mysqli_query($conn,$query);
                        while($rows=mysqli_fetch_assoc($result)){
                            $taskid= $rows["TaskID"];
                            $query1 = "SELECT * FROM `projecttask` WHERE `ProjectID` = '$pid' AND `TaskID`='$taskid'";
                              $result1 = mysqli_query($conn,$query1);
                              if(mysqli_num_rows($result1)>0){
                                $query4 = "SELECT * FROM `usertask` WHERE `sno` = '$uid' AND `TaskID`='$taskid'";
                                $result4 = mysqli_query($conn,$query4);
                                if(mysqli_num_rows($result4)>0){
                        
                    ?>
                   <form method="post" action="addtask.php">
                    <div class="task">
                        <div class="taskdesc">
                            <p><?php echo $rows['TaskName']; ?></p>
                        </div>
                        
                        <div class="assigned">
                            <?php

                                $query8 = "SELECT * FROM `usertask` WHERE `TaskID` = '$taskid'";
                                $result8 = mysqli_query($conn,$query8);

                                $row8=mysqli_fetch_assoc($result8);
                                $user = $row8['sno'];
                                $query8 = "SELECT * FROM `users` WHERE `sno` = '$user'";
                                $result9 = mysqli_query($conn,$query8);

                                $row9=mysqli_fetch_assoc($result9);
                            
                                $name= ucfirst($row9["name"]);
                                $userletter = substr($name, 0, 1);

                            ?>
                            <div class="person"><?php echo $userletter;?>
                            <span class="tooltiptext"><?php echo $name;?></span>
                        </div>
                        </div>
                        <input type="hidden" value="<?php echo $rows['TaskID'];?>" name="index"/>
                        <input type="submit" value = "Next Stage >" class="statusbtn" name="next"/>
                        
                        
                    </div>
                    </form>
                    <?php
                        }
                    }}
                    ?>
                    
                </div>
    
    
    
                <div class="status">
                    <div class="header">
                        <p>Completed</p>
                        <div class="remain">4</div>
                        <div class="addbtn">+</div>
                    </div>
                    <?php
                   
                        $query = "SELECT * FROM `Task` WHERE `status` = 2";
                        $result = mysqli_query($conn,$query);
                        while($rows=mysqli_fetch_assoc($result)){
                            $taskid= $rows["TaskID"];
                            $query1 = "SELECT * FROM `projecttask` WHERE `ProjectID` = '$pid' AND `TaskID`='$taskid'";
                              $result1 = mysqli_query($conn,$query1);
                              if(mysqli_num_rows($result1)>0){
                                $query4 = "SELECT * FROM `usertask` WHERE `sno` = '$uid' AND `TaskID`='$taskid'";
                                $result4 = mysqli_query($conn,$query4);
                                if(mysqli_num_rows($result4)>0){
                        
                    ?>
                   <form method="post" action="addtask.php">
                    <div class="task">
                        <div class="taskdesc">
                            <p><?php echo $rows['TaskName']; ?></p>
                        </div>
                        
                        <div class="assigned">
                            <?php

                                $query8 = "SELECT * FROM `usertask` WHERE `TaskID` = '$taskid'";
                                $result8 = mysqli_query($conn,$query8);

                                $row8=mysqli_fetch_assoc($result8);
                                $user = $row8['sno'];
                                $query8 = "SELECT * FROM `users` WHERE `sno` = '$user'";
                                $result9 = mysqli_query($conn,$query8);

                                $row9=mysqli_fetch_assoc($result9);
                            
                                $name= ucfirst($row9["name"]);
                                $userletter = substr($name, 0, 1);

                            ?>
                            <div class="person"><?php echo $userletter;?>
                            <span class="tooltiptext"><?php echo $name;?></span>
                        </div>
                        </div>
                        <input type="hidden" value="<?php echo $rows['TaskID'];?>" name="index"/>
                        <input type="submit" value = "Next Stage >" class="statusbtn" name="next"/>
                        
                        
                    </div>
                    </form>
                    <?php
                              }  
                    }}
                    ?>
                </div>
    
    
    
                <div class="status">
                    <div class="header">
                        <p>REVIEW</p>
                        <div class="remain">2</div>
                        <div class="addbtn">+</div>
                    </div>
                    <?php
                   
                        $query = "SELECT * FROM `Task` WHERE `status` = 3";
                        $result = mysqli_query($conn,$query);
                        while($rows=mysqli_fetch_assoc($result)){
                            $taskid= $rows["TaskID"];
                            $query1 = "SELECT * FROM `projecttask` WHERE `ProjectID` = '$pid' AND `TaskID`='$taskid'";
                              $result1 = mysqli_query($conn,$query1);
                              if(mysqli_num_rows($result1)>0){
                                $query4 = "SELECT * FROM `usertask` WHERE `sno` = '$uid' AND `TaskID`='$taskid'";
                                $result4 = mysqli_query($conn,$query4);
                                if(mysqli_num_rows($result4)>0){
                        
                    ?>
                    <div class="task">
                        <div class="taskdesc">
                            <p><?php echo $rows['TaskName']; ?></p>
                        </div>
                        
                        <div class="assigned">
                            <?php

                                $query8 = "SELECT * FROM `usertask` WHERE `TaskID` = '$taskid'";
                                $result8 = mysqli_query($conn,$query8);

                                $row8=mysqli_fetch_assoc($result8);
                                $user = $row8['sno'];
                                $query8 = "SELECT * FROM `users` WHERE `sno` = '$user'";
                                $result9 = mysqli_query($conn,$query8);

                                $row9=mysqli_fetch_assoc($result9);
                            
                                $name= ucfirst($row9["name"]);
                                $userletter = substr($name, 0, 1);

                            ?>
                            <div class="person"><?php echo $userletter;?>
                            <span class="tooltiptext"><?php echo $name;?></span>
                        </div>
                        </div>
                        
                        <div class="statusbtn">Next Stage > </div>
                    </div>
                    <?php
                              }
                    }}
                    ?>
                </div>
            </div>

        

            </div>



            
        </div>
    </div>
    <script>
        document.getElementById("kanban").style.display = "flex";
        tablinks = document.getElementsByClassName("toggle");
        tablinks[1].className += " active";
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("adduserbtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal
        btn.onclick = function() {
        modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        }
    </script>
    <script src="index.js"></script>
</body>
</html>