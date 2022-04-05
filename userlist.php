<?php 


include 'connection.php';

 
// Get search term 
// $sterm = $_GET['term'];
$sterm = $_GET['term'];
$tname = $_GET['teamname'];

$query3 = "SELECT * FROM `Teams` WHERE `TeamName`='$tname'";
$result3 = mysqli_query($conn,$query3);
$row3 = mysqli_fetch_assoc($result3);
$tid = $row3['TeamID']; 
// Fetch matched data from the database 
$query = "SELECT * FROM users WHERE email LIKE '%".$sterm."%' ORDER BY email ASC "; 
 $result = mysqli_query($conn,$query);
// Generate array with skills data 
$userData = array(); 

    while($rows=mysqli_fetch_assoc($result)){
        $uid = $rows['sno']; 
        $query1 = "SELECT * FROM teamusers WHERE sno ='$uid' AND TeamID ='$tid'"; 
        $result1 = mysqli_query($conn,$query1);
        if(mysqli_num_rows($result1)>0){
            $data['id'] = $rows['sno']; 
            $data['value'] = $rows['email']; 
            array_push($userData, $data);
        }
         
    } 
 

// Return results as json encoded array 
echo json_encode($userData);
?>