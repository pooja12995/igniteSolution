<?php
   $servername = "localhost";
   $username   = "root";
   $password   = "";
   $dbName     ="gutendex";
   // Create connection
   $conn = new mysqli($servername, $username, $password,$dbName);
   if($conn->connect_error){
       trigger_error('Database connection has failed'.$conn->$connect_error,E_USER_ERROR);
   }

?>
<?php

    $stmt=mysqli_query($conn,"select code from books_language");
    $result=mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    $Information=$result;
    
$post_data= json_encode($Information);
 echo $post_data;
?>

  