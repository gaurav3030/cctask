<?php
session_start();
include 'connection.php';
if (isset($_POST["addbtn"])){
    $taskname = $_POST['taskname'];
    $taskdesc =  $_POST['taskdesc'];
    $deadline =  $_POST['deadline'];
    $assignto =  $_POST['assignto'];
    $user =  $_POST['userlist'];
    
    
    	
			

			if (isset($taskname) && isset($taskdesc)&& isset($deadline)&& isset($assignto)) {
//                $data['taskname'] = $taskname; 
//                $data['taskdesc'] = $taskdesc; 
//                $data['deadline'] = $deadline; 
//                $data['$assignto'] = $assignto;
//                $data['status'] = 0;
                $query = "INSERT INTO `Task`(`TaskName`, `TaskDesc`, `Deadline`, `status`) VALUES ('$taskname','$taskdesc','$deadline',0)";
                $result = mysqli_query($conn,$query);
                $query2 = "SELECT * FROM `task` WHERE `TaskName`='$taskname' AND `TaskDesc`='$taskdesc'";
                $result2 = mysqli_query($conn,$query2);
                $row2 = mysqli_fetch_assoc($result2);
                $taskid=$row2["TaskID"];
                $query3 = "SELECT * FROM `users` WHERE `email`='$user'";
                $result3 = mysqli_query($conn,$query3);
                $row3 = mysqli_fetch_assoc($result3);
                $uid=$row3["sno"];
                $query4 = "SELECT * FROM `teams` WHERE `TeamName`='$assignto'";
                $result4 = mysqli_query($conn,$query4);
                $row4 = mysqli_fetch_assoc($result4);
                $tid=$row4["TeamID"];
                $pid=$_SESSION["projectid"];

                $query = "INSERT INTO `projecttask`(`ProjectID`, `TaskID`) VALUES ('$pid','$taskid')";
                $result = mysqli_query($conn,$query);
                $query = "INSERT INTO `teamtask`(`TaskID`, `TeamID`) VALUES ('$taskid','$tid')";
                $result = mysqli_query($conn,$query);
                $query = "INSERT INTO `usertask`(`sno`, `TaskID`) VALUES ('$uid','$taskid')";
                $result = mysqli_query($conn,$query);

//                if(!isset($_SESSION['task'])){
//                    $_SESSION['task'][0]=$data;
//                }else{
//                    array_push($_SESSION['task'], $data); 
//                }  
				
				
				
			}
			else 
			{
				echo '<script type="text/javascript">';
				echo ' alert("Wrong username/password combination")';  //not showing an alert box.
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
    <style>
        *{
    margin: 0;
    padding: 0;
    outline: none;
    font-family: sans-serif;
}
a{
    outline: none;
    text-decoration: none;
}
.navbar{
    height: 60px;
    width: 100vw;
    border-bottom:1.5px solid #ccc;
    box-shadow: 0 1px 5px 1px #ccc;

}
.logo{
    float: left;
    width: auto;
    font-size: 30px;
    font-weight: bolder;
    padding: 10px;
    color: rgb(16, 106, 241);
}
.right{
    float: right;
}
.profile{
    display: inline-block;
    background: #ccc;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin: 10px;
}
.newbtn{
    display: inline-block;
    font-size: 14px;
    color: white;
    padding: 22px 0;
    width: 150px;
    margin-left: 10px;
    background: rgb(16, 106, 241);
    vertical-align: top;
    font-weight: bold;

}
.newbtn p{
    text-align: center;
}
    </style>
    
</head>
<body>
    
       <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- jQuery UI library -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    
    
    
    <script>
    $(function() {
        $('#teamlist').autocomplete({
            source: "teamlist.php"
        });
    });


    $(function() {
    $( "#userlist" ).autocomplete({
        source: function(request, response) {
            $.getJSON(
                "userlist.php",
                { term:request.term, teamname:$('#teamlist').val() }, 
                response
            );
        },
        
    });
});
    </script>
    <div class="navbar">
        <div class="logo">KONTRI</div>
        <div class="right">
            <div class="profile"></div>
            <a href="pmproject.php">
            <div class="newbtn">
                <p>Go To Kanban Board</p>
            </div>
            </a>
        </div>
        
    </div>
    <div class="auth-page">
        <h2>Add Task </h2>
        
        <form onsubmit="return validateForm()" action="newtask.php" method="post">
            <label htmlFor="taskname">Task Name</label>
            <input id="taskname" type="text" name="taskname"/>
            <label htmlFor="taskdesc">Task Description</label>
            <input id="taskdesc" type="text" name="taskdesc"/>
            <label htmlFor="deadline">Deadline</label>
            <input id="deadline" type="date" name="deadline"/>
            <label htmlFor="assignto">Assign to Team</label>
            <input type="text" name="assignto" id="teamlist"/>
            <label htmlFor="assignto">Assign to User</label>
            <input type="text" name="userlist" id="userlist"/>
            <input type="submit" id="addbtn" value="Add task" name="addbtn"/>
        </form>
        
        
    </div>
    <script>
        function validateForm() {
            var taskname = document.getElementById("taskname").value;
            var taskdesc = document.getElementById("taskdesc").value;
            var deadline = document.getElementById("deadline").value;
            var assignto = document.getElementById("assignto").value;
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
            if (assignto == "") {
                alert("assignto must be filled out");
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