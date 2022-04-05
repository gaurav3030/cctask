<?php
session_start();
include 'connection.php';
$email = $_SESSION['email'];

if(!isset($_SESSION['email'])){
    header("location: signup.php");
}
if($_SESSION['usertype']=="PM"){
    $query1 = "SELECT * FROM `projectmanagers` WHERE `Email`='$email'";
    $result1 = mysqli_query($conn,$query1);
    if(mysqli_num_rows($result1)==0){
        header("location: logout.php");
    }else{
        $row1 = mysqli_fetch_assoc($result1);
        $pid = $row1["PID"];
    }
}else{
    $query1 = "SELECT `sno`, `name`, `email`, `password` FROM `users` WHERE `email`='$email'";
    $result1 = mysqli_query($conn,$query1);
    if(mysqli_num_rows($result1)==0){
        header("location: logout.php");
    }else{
        $row1 = mysqli_fetch_assoc($result1);
        $pid = $row1["sno"];
    }
       
}
if (isset($_POST["addproject"])){

    $projecttitle = $_POST["projecttitle"];
    $projectdesc = $_POST["projectdesc"];
    $deadline = $_POST["deadline"];
    if (isset($projecttitle) && isset($projectdesc)&& isset($deadline)) {
        
        $query = "INSERT INTO `projects`(`ProjectName`, `ProjectDesc`, `Deadline`) VALUES ('$projecttitle','$projectdesc','$deadline')";
        $result = mysqli_query($conn,$query);


        $query2 = "SELECT * FROM `projects` WHERE `ProjectName`='$projecttitle'";
        $result2 = mysqli_query($conn,$query2);
        $row2 = mysqli_fetch_assoc($result2);
        $projectid=$row2["ProjectID"];
        $query = "INSERT INTO `createsporject`(`PID`, `ProjectID`) VALUES ('$pid','$projectid')";
        $result = mysqli_query($conn,$query);
        header("location: projects.php");
        
        
    }
    else 
    {
        echo '<script type="text/javascript">';
        echo ' alert("Enter all fields")';  //not showing an alert box.
        echo '</script>';
    }


    
    header("location: addtask.php");
}
if (isset($_POST["openproject"])){
    $_SESSION["projectid"] = $_POST['index'];
    if($_SESSION['usertype']=="PM"){ 
        header("location: pmproject.php");
    }else{
        header("location: addtask.php");
    }
    
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="projects.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">KONTRI</div>
        <div class="right">
            <div class="profile"></div>
            <?php
                if($_SESSION['usertype']=="PM"){
            ?>
            <div class="newbtn" id="newpbtn">
                <p>+ NEW PROJECT</p>
            </div>
            <?php
            }
            ?>
        </div>
        
    </div>

    <!-- Trigger/Open The Modal -->
    

    <!-- The Modal -->
    <div id="newpmodal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span id="newpclose" class="close">&times;</span>
        <h1>Add Project</h1>
            <div class="addform">
            <form action="projects.php" method="post">
                <label for="projecttitle">Project Title</label>
                <input type="text" name="projecttitle" id="projecttitle">
                <label for="projectdesc">Project Description</label>
                <input type="text" name="projectdesc" id="projectdesc">
                <label for="deadline">Deadline</label>
                <input type="date" name="deadline" id="deadline">
                <input type="submit" value="Add Project" name="addproject">
            </form>
        </div>
    </div>

    </div>


    <div class="content">
        <?php
            if($_SESSION['usertype']=="PM"){       
            $query = "SELECT * FROM `createsporject` WHERE `PID` = '$pid'";
            $result = mysqli_query($conn,$query);
            while($row=mysqli_fetch_assoc($result)){
                $projectid = $row["ProjectID"];
                $query1 = "SELECT * FROM `projects` WHERE `ProjectID` = '$projectid'";
                $result1 = mysqli_query($conn,$query1);
                $rows=mysqli_fetch_assoc($result1);
                   
        ?>
        <form method="post" action="projects.php">
        <div class="project">
            <input type="hidden" value="<?php echo $rows['ProjectID'];?>" name="index"/>
            <div class="projectname"><?php echo $rows['ProjectName']; ?></div>
            <div class="projectdesc"><?php echo $rows['ProjectDesc']; ?></div>
            <input type="submit" value = "View Project" class="statusbtn" name="openproject"/>
        </div>
            </form>
        <?php
                        
            }
        }else{
            $query = "SELECT * FROM `userproject` WHERE `sno` = '$pid'";
            $result = mysqli_query($conn,$query);
            while($row=mysqli_fetch_assoc($result)){
                $projectid = $row["ProjectID"];
                $query1 = "SELECT * FROM `projects` WHERE `ProjectID` = '$projectid'";
                $result1 = mysqli_query($conn,$query1);
                $rows=mysqli_fetch_assoc($result1);
                ?>

                <form method="post" action="projects.php">
                <div class="project">
                    <input type="hidden" value="<?php echo $rows['ProjectID'];?>" name="index"/>
                    <div class="projectname"><?php echo $rows['ProjectName']; ?></div>
                    <div class="projectdesc"><?php echo $rows['ProjectDesc']; ?></div>
                    <input type="submit" value = "View Project" class="statusbtn" name="openproject"/>
                </div>
            </form>
                <?php
            }
        }
        ?>
       
    </div>
    <script>
    var modal = document.getElementById("newpmodal");

    // Get the button that opens the modal
    var btn = document.getElementById("newpbtn");

    // Get the <span> element that closes the modal
    var span = document.getElementById("newpclose");

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
</body>
</html>