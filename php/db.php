<?php

$conn= new mysqli('localhost','root','','userform');
if(!$conn)
{
    echo" Connection Denied". mysqli_connect_error();

}

?>