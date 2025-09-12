<?php
if(isset($_GET["id"])){

    $id = $_GET["id"];

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $database = "sugarbunnies";

//Criação da conexão

$connection = new mysqli($servername, $username, $password, $database);

$sql = "DELETE FROM lista_personagens WHERE id=$id";

    $connection->query($sql);

    header("location: index.php");
    exit;

}
?>