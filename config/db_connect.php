<?php 

//connect to database

$conn = mysqli_connect('localhost', 'abby', 'Myphp@22', 'allys_pizza' );

//check connection 
if(!$conn){
    echo 'Connection error:' . mysqli_connect_error();
}

?>