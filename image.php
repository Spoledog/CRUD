<?php
// filepath: c:\Users\cedro.0990\Desktop\trabalho\image.php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "sugarbunnies";

$connection = new mysqli($servername, $username, $password, $database);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT image_data FROM lista_personagens WHERE id = $id LIMIT 1";
$result = $connection->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    header("Content-Type: image/jpeg"); // ou image/png, conforme o tipo salvo
    echo $row['image_data'];
} else {
    // Imagem padrão caso não encontre
    header("Content-Type: image/png");
    readfile("no-image.png");
}