<?php
    session_start();
    include 'connection.php';
    $pid=$_SESSION["projectid"];
    if(!isset($_SESSION["projectid"])){
        header("location: projects.php");
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
    .taskdesc{
    display: block;
    color: #666;
    font-size: 15px;
    margin-top:10px;
}
.person{
    display: inline-block;
    background: #fff;
    width: 25px;
    height: 16px;
    border-radius: 50%;
    margin: 5px;
    text-align: center;
    padding: 4.5px 0 ;
    font-size: 16px;
    border: 2px solid rgb(16, 106, 241);
    font-weight:bolder;
    color:#777;
    position:relative;
}
.person .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;

  /* Position the tooltip */
  position: absolute;
  z-index: 1;
  width: 120px;
  bottom: 100%;
  left: 50%;
  margin-left: -60px;
}

.person:hover .tooltiptext {
  visibility: visible;
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
            <a href="newtask.php">
            <div class="newbtn">
                <p>+ NEW TASK</p>
            </div>
            </a>
        </div>
        
    </div>
    <div class="content">
        <div class="sidebar">
            
            <a href="manageprojectteam.php">
            <div class="adduserbtn" id="adduserbtn">
                <p>Manage Teams</p>
            </div>
    </a>
        </div>
       
        <div class="container">
            <div id="kanban" class="tab">
                <div class="status">
                    <div class="header">
                        <p>ASSIGNED</p>
                        <?php
                             $query3 = "SELECT * FROM `Task` WHERE `status` = 0";
                             $result3 = mysqli_query($conn,$query3);
                             $count=0;
                             while($rows=mysqli_fetch_assoc($result3)){
                                $tid= $rows["TaskID"];
                                $query4 = "SELECT * FROM `projecttask` WHERE `ProjectID` = '$pid' AND `TaskID`='$tid'";
                                $result4 = mysqli_query($conn,$query4);
                                if(mysqli_num_rows($result4)>0){
                                    $count=$count+1;
                                }
                                
                             }
                        ?>
                        <div class="remain"><?php echo $count;?></div>
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
                    <form method="post" action="pmproject.php">
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
                        <input type="submit" value = "Next Stage >" class="statusbtn" name="next"/>
                        
                        
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
                        <?php
                             $query3 = "SELECT * FROM `Task` WHERE `status` = 1";
                             $result3 = mysqli_query($conn,$query3);
                             $count=0;
                             while($rows=mysqli_fetch_assoc($result3)){
                                $tid= $rows["TaskID"];
                                $query4 = "SELECT * FROM `projecttask` WHERE `ProjectID` = '$pid' AND `TaskID`='$tid'";
                                $result4 = mysqli_query($conn,$query4);
                                if(mysqli_num_rows($result4)>0){
                                    $count=$count+1;
                                }
                                
                             }
                        ?>
                        <div class="remain"><?php echo $count;?></div>
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
                   <form method="post" action="pmproject.php">
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
                        <input type="submit" value = "Next Stage >" class="statusbtn" name="next"/>
                        
                        
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
                        <?php
                             $query3 = "SELECT * FROM `Task` WHERE `status` = 2";
                             $result3 = mysqli_query($conn,$query3);
                             $count=0;
                             while($rows=mysqli_fetch_assoc($result3)){
                                $tid= $rows["TaskID"];
                                $query4 = "SELECT * FROM `projecttask` WHERE `ProjectID` = '$pid' AND `TaskID`='$tid'";
                                $result4 = mysqli_query($conn,$query4);
                                if(mysqli_num_rows($result4)>0){
                                    $count=$count+1;
                                }
                                
                             }
                        ?>
                        <div class="remain"><?php echo $count;?></div>
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
                   <form method="post" action="pmproject.php">
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
                        <input type="submit" value = "Next Stage >" class="statusbtn" name="next"/>
                        
                        
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
                        <?php
                             $query3 = "SELECT * FROM `Task` WHERE `status` = 3";
                             $result3 = mysqli_query($conn,$query3);
                             $count=0;
                             while($rows=mysqli_fetch_assoc($result3)){
                                $tid= $rows["TaskID"];
                                $query4 = "SELECT * FROM `projecttask` WHERE `ProjectID` = '$pid' AND `TaskID`='$tid'";
                                $result4 = mysqli_query($conn,$query4);
                                if(mysqli_num_rows($result4)>0){
                                    $count=$count+1;
                                }
                                
                             }
                        ?>
                        <div class="remain"><?php echo $count;?></div>
                        
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
                        
                        <div class="statusbtn">Next Stage > </div>
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
                    <div class="task">
                        <div class="taskdesc">
                            <p>Build UI For Chat Feature</p>
                        </div>
                        
                        <div class="assigned">
                            <div class="person"></div>
                            <div class="person"></div>
                        </div>
                        
                        <div class="statusbtn">Next Stage > </div>
                    </div>
                </div>
    
    
    
                <div class="status">
                    <div class="header">
                        <p>IN PROGRESS</p>
                        <div class="remain">2</div>
                        <div class="addbtn">+</div>
                    </div>
                    <div class="task">
                        <div class="taskdesc">
                            <p>Build UI For Chat Feature</p>
                        </div>
                        
                        <div class="assigned">
                            <div class="person"></div>
                            <div class="person"></div>
                            <div class="person"></div>
                        </div>
                        
                        <div class="statusbtn">Next Stage > </div>
                    </div>
                    <div class="task">
                        <div class="taskdesc">
                            <p>Build UI For Chat Feature</p>
                        </div>
                        
                        <div class="assigned">
                            <div class="person"></div>
                            
                        </div>
                        
                        <div class="statusbtn">Next Stage > </div>
                    </div>
                </div>
    
    
    
                <div class="status">
                    <div class="header">
                        <p>Completed</p>
                        <div class="remain">4</div>
                        <div class="addbtn">+</div>
                    </div>
                    <div class="task">
                        <div class="taskdesc">
                            <p>Build UI For Chat Feature</p>
                        </div>
                        
                        <div class="assigned">
                            <div class="person"></div>
                            <div class="person"></div>
                        </div>
                        
                        <div class="statusbtn">Next Stage > </div>
                    </div>
                   
                </div>
    
    
    
                <div class="status">
                    <div class="header">
                        <p>REVIEW</p>
                        <div class="remain">2</div>
                        <div class="addbtn">+</div>
                    </div>
                    <div class="task">
                        <div class="taskdesc">
                            <p>Build UI For Chat Feature</p>
                        </div>
                        
                        <div class="assigned">
                            <div class="person"></div>
                            <div class="person"></div>
                        </div>
                        
                        <div class="statusbtn">Next Stage > </div>
                    </div>
                    
                </div>
                
        

            </div>



            
        </div>
    </div>
    <script>
        document.getElementById("kanban").style.display = "flex";
        tablinks = document.getElementsByClassName("toggle");
        tablinks[1].className += " active";
        
    </script>
    <script src="index.js"></script>
</body>
</html>