<?php
session_start();
$showAlert = false;
$showError = false;
$showErrorEmail = false;

if($_SERVER["REQUEST_METHOD"]=="POST"){
    include 'connection.php';
    if (isset($_POST["register"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $passwordhash=password_hash($password, PASSWORD_DEFAULT);
        // email already exists
        $existSql = "SELECT * FROM `projectmanagers` WHERE Email = '$email'";
        $result = mysqli_query($conn, $existSql);
        $numExistRows = mysqli_num_rows($result);
        if($numExistRows > 0){
            $showErrorEmail = true;
            
        }
        
        else{
            if($password == $cpassword ){
                
                $sql= "INSERT INTO `projectmanagers` ( `Name`, `Email`, `Password`) VALUES ('$name', '$email', '$passwordhash')";
                $result = mysqli_query($conn, $sql);
               
                if($result){
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $email;
                    $_SESSION['usertype'] = "PM";
                    header("location: index.php");

                }
            }
            else{
                $showError = true;
            }
        }
        if($showAlert){
            echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your account is now created and you can login
            <button type="button" class="close btn btn-secondary btn-sm" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div> ';
        }
        if($showError){
            echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Oops!</strong> Password dosent match, please try again.
            <button type="button" class="close btn btn-secondary btn-sm" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div> ';
        }
        if($showErrorEmail){
            echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Oops!</strong> This email already exist, please try with other email.
            <button type="button" class="close btn btn-secondary btn-sm" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div> ';
        }
    }
    if (isset($_POST["login"])){
        $email = $_POST["email"];
        $password = $_POST["pwd2"];
        
        $sql = "Select * from projectmanagers where Email='$email'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1){
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password,$row['Password'])) {
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['usertype'] = "PM";
                header("location: index.php");
                
            } else {
                $showError = true;
            }
            
    
        } 
        else{
            
        }
        if($showError){
            echo '<script>alert("invalid credentials")</script>';
        }
    }

    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Sign-up</title>
    <link rel="stylesheet" href="./log.css">
</head>
<body>

    <h2>
        Manage Your Projects: Login / Sign-up
    </h2>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="pmsignup.php" method="POST" name="form1" >
                <h1>Create Account</h1>
                <input name="name"  type="text" placeholder="Name" >
				<input name="email" type="email" placeholder="Email" >
                <input name="password" type="password" placeholder="Password">
                <input name="cpassword" type="password" placeholder="Confirm Password">
                <button type="submit" onclick="validate1()" name="register">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form name="form2" action="pmsignup.php" method="POST">
                <h1>Log In</h1>
                <input name="email" type="email" placeholder="Email">
                <input name="pwd2" type="password" placeholder="Password" >
                <button onclick="validate2()" name = login>Log In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
					<p>To keep connected with us please login with your personal info</p>
					<button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script src="./log.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body> 
</html>