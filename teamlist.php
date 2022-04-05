<?php 
session_start();

include 'connection.php';

$pid=$_SESSION["projectid"]; 
// Get search term 
$sterm = $_GET['term'];

 
// Fetch matched data from the database 
$query = "SELECT * FROM teams WHERE TeamName LIKE '%".$sterm."%' ORDER BY TeamName ASC "; 
 $result = mysqli_query($conn,$query);
// Generate array with skills data 
$compData = array(); 

    while($rows=mysqli_fetch_assoc($result)){ 
        $tid=$rows['TeamID'];
        $query1 = "SELECT * FROM projectteams WHERE TeamID = '$tid' AND ProjectID='$pid'"; 
        $result1 = mysqli_query($conn,$query1);
        if(mysqli_num_rows($result1)>0){
        $data['id'] = $rows['TeamID']; 
        $data['value'] = $rows['TeamName']; 
        array_push($compData, $data); 
        }
    } 
 
 
// Return results as json encoded array 
echo json_encode($compData);
?>