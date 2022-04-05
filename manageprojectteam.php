<?php
session_start();
include 'connection.php';
$email = $_SESSION['email'];
$pid=$_SESSION["projectid"];
    if (isset($_POST["addteam"])){

        $teamname = $_POST["teamname"];

        if (isset($teamname)) {
            
            $query = "INSERT INTO `Teams`(`TeamName`) VALUES ('$teamname')";
            $result = mysqli_query($conn,$query);
    
    
            $query2 = "SELECT * FROM `Teams` WHERE `TeamName`='$teamname'";
            $result2 = mysqli_query($conn,$query2);
            $row2 = mysqli_fetch_assoc($result2);
            $teamid=$row2["TeamID"];
            $query = "INSERT INTO `projectteams`(`TeamID`, `ProjectID`) VALUES ('$teamid','$pid')";
            $result = mysqli_query($conn,$query);
            header("location: manageprojectteam.php");
            
            
        }
        else 
        {
            echo '<script type="text/javascript">';
            echo ' alert("Enter all fields")';  //not showing an alert box.
            echo '</script>';
        }
    
    
        
        
    }
    if (isset($_POST["adduser"])){
        $useremail = $_POST["useremail"];
        $teamid = $_GET["id"];
        $query2 = "SELECT * FROM `users` WHERE `email` ='$useremail' ";
            $result2 = mysqli_query($conn,$query2);
            if(mysqli_num_rows($result2)==0){
                echo '<script type="text/javascript">';
                echo ' alert("User is not registered")';  //not showing an alert box.
                echo '</script>';
            }else{
                $row2 = mysqli_fetch_assoc($result2);
                $uid=$row2["sno"];
                $query = "INSERT INTO `teamusers`(`sno`, `TeamID`) VALUES ('$uid','$teamid')";
                $result = mysqli_query($conn,$query);
                $query = "INSERT INTO `userproject`(`sno`, `ProjectID`) VALUES ('$uid','$pid')";
                $result = mysqli_query($conn,$query);
                header("location: manageprojectteam.php");
            }

    }
    if (isset($_POST["removeuser"])){
        $uid = $_GET["uid"];
        $teamid = $_GET["teamid"];
        $query2 = "DELETE FROM `teamusers` WHERE `TeamID`= '$teamid' and `sno` ='$uid'";
            $result2 = mysqli_query($conn,$query2);
            

    }
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="teamproject.css">
</head>
<body>
    <div class="navbar">
        <a href="pmproject.php">
        <div class="logo">KONTRI</div>
        </a>
        <div class="right">
            <div class="profile"></div>
            
            <div class="newbtn" id="newteambtn">
                <p>+ NEW TEAM</p>
            </div>
            
        </div>
        
        
    </div>
    <div id="newteammodal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span id="newteamclose" class="close">&times;</span>
        <h1>Add Team</h1>
        <div class="addform">
            <form action="manageprojectteam.php" method="post">
                <label for="teamname">Team Name</label>
                <input type="text" name="teamname" id="teamname">
                
                <input type="submit" value="Add Team" name="addteam">
            </form>
        </div>
    </div>
    </div>
    

    


    
    <div class="teams">
        <?php
            $query2 = "SELECT * FROM `projectteams` WHERE `ProjectID`='$pid'";
            $result2 = mysqli_query($conn,$query2);
            while($row=mysqli_fetch_assoc($result2)){
                $teamid=$row['TeamID'];
                $query3 = "SELECT * FROM `Teams` WHERE `TeamID`='$teamid'";
                $result3 = mysqli_query($conn,$query3);
                $row3 = mysqli_fetch_assoc($result3);
                
        ?>
        <div class="team">
            <div class="teamname">
            
                <h4><?php echo $row3['TeamName'];?></h4>
                
              
            </div>
            <div class="teammembers">
                <?php
                    $query5 = "SELECT * FROM `teamusers` WHERE `TeamID`='$teamid'";
                    $result5 = mysqli_query($conn,$query5);
                    while($row5=mysqli_fetch_assoc($result5)){
                        $uid=$row5['sno'];
                        $query6 = "SELECT * FROM `users` WHERE `sno`='$uid'";
                        $result6 = mysqli_query($conn,$query6);
                        $row6 = mysqli_fetch_assoc($result6);
                        
                ?>
                <form  method="post" action="manageprojectteam.php?uid=<?php echo $uid; ?>&teamid=<?php echo $teamid; ?>">
                <div class="user">
                
                    <div class="val"><?php echo $row6["name"]; ?></div>
                    <div class="val"><?php echo $row6["email"]; ?></div>
                    <input type="submit" value="X" name="removeuser" class="val">
                
                </div>
                </form>
                <?php
            }
        ?>
                <div class="user">
                <form  class="userform" method="post" action="manageprojectteam.php?action=add&id=<?php echo $teamid; ?>">
                
                <input type="text" name="useremail" id="useremail" placeholder="enter email">
                <input type="hidden" name="teamid" value="<?php echo $teamid; ?>">
                <input type="submit" value="Add User" name="adduser">
                
                </form>
                </div>
            </div>
        </div>
        <?php
            }
        ?>



    </div>
    <script>
var coll = document.getElementsByClassName("teamname");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}

    var modal = document.getElementById("newteammodal");

    // Get the button that opens the modal
    var btn = document.getElementById("newteambtn");

    // Get the <span> element that closes the modal
    var span = document.getElementById("newuserclose");

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

    var modal1 = document.getElementById("newusermodal");

    // Get the button that opens the modal
    var btn1 = document.getElementById("newuserbtn");

    // Get the <span> element that closes the modal
    var span1 = document.getElementById("newuserclose");

    // When the user clicks on the button, open the modal
    btn1.onclick = function() {
        modal1.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span1.onclick = function() {
        modal1.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }
    }

</script>
</body>
</html>