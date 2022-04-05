<?php
session_start();
include 'connection.php';
$email = $_SESSION['email'];
if(!isset($_SESSION['email'])){
    header("location: signup.php");
}
$query1 = "SELECT `PID`, `Name`, `Email`, `Password` FROM `projectmanagers` WHERE `Email`='$email'";
$result1 = mysqli_query($conn,$query1);
if(mysqli_num_rows($result1)==0){
    header("location: logout.php");
}else{
    $row1 = mysqli_fetch_assoc($result1);
    $pid = $row1["PID"];
}
if (isset($_POST["addbtn"])){
    $taskname = $_POST['projectname'];
    $taskdesc =  $_POST['projectdesc'];
    $deadline =  $_POST['deadline'];

    
    
    	
			

			if (isset($taskname) && isset($taskdesc)&& isset($deadline)) {
//                $data['taskname'] = $taskname; 
//                $data['taskdesc'] = $taskdesc; 
//                $data['deadline'] = $deadline; 
//                $data['$assignto'] = $assignto;
//                $data['status'] = 0;
                $query = "INSERT INTO `projects`(`ProjectName`, `ProjectDesc`, `Deadline`) VALUES ('$taskname','$taskdesc','$deadline')";
                $result = mysqli_query($conn,$query);
                $query2 = "SELECT * FROM `projects` WHERE `ProjectName`='$taskname'";
                $result2 = mysqli_query($conn,$query2);
                $row2 = mysqli_fetch_assoc($result2);
                $projectid=$row2["ProjectID"];
                $query = "INSERT INTO `createsporject`(`PID`, `ProjectID`) VALUES ('$pid','$projectid')";
                $result = mysqli_query($conn,$query);
//                if(!isset($_SESSION['task'])){
//                    $_SESSION['task'][0]=$data;
//                }else{
//                    array_push($_SESSION['task'], $data); 
//                }  
                header("location: projects.php");
				
				
			}
			else 
			{
				echo '<script type="text/javascript">';
				echo ' alert("Enter all fields")';  //not showing an alert box.
				echo '</script>';
			}
    

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="addtask.css">
    
</head>
<body>
    <div class="auth-page">
        <h2>Register </h2>
        
        <form onsubmit="return validateForm()" action="addProjects.php" method="post">
            <label htmlFor="projectname">Project Name</label>
            <input id="projectname" type="text" name="projectname"/>
            <label htmlFor="projectdesc">Project Description</label>
            <input id="projectdesc" type="text" name="projectdesc"/>
            <label htmlFor="deadline">Deadline</label>
            <input id="deadline" type="date" name="deadline"/>
            <input type="submit" id="addbtn" value="Register task" name="addbtn"/>
        </form>
        <a href="addtask.php">home</a>
        
    </div>
    <script>
        function validateForm() {
            var taskname = document.getElementById("projectname").value;
            var taskdesc = document.getElementById("projectdesc").value;
            var deadline = document.getElementById("deadline").value;
            
            if (taskname == "") {
                alert("taskname must be filled out");
                console.log("sdfs");
                return false;
            }
            if (taskdesc == "") {
                alert("taskdesc must be filled out");
                return false;
            }
            if (deadline== "") {
                alert("deadline must be filled out");
                return false;
            }
        }
        var button = document.getElementById("addbtn");
        button.addEventListener("onclick",()=>{
            console.log("here");
            validateForm();
        });
    </script>
</body>
</html>