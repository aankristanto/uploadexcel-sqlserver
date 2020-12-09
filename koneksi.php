<?php
$serverName = "localhost";
$connectionOptions = array(
    "Database" => "cobacrud1",
    "Uid" => "sa",
    "PWD" => "Admin12345"
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if($conn)
    echo "Connected!"

?>