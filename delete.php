<?php
if(isset($_GET["id"])){

    $id = $_GET["id"];

    $servername = "localhost";
    $username = "root";
    $password = "root";
$database = "dt_crud";

//Criação da conexão

$connection = new mysqli($servername, $username, $password, $database);

$sql = "DELETE FROM clients WHERE id=$id";

    $connection->query($sql);

    header("location: index.php");
    exit;

}
?>