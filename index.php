<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
    <title>My Shop</title>
</head>

<body>
    <div class="container my-5">
        <h2>List of clients</h2>
        <a href="create.php" class="btn btn-primary" role="button">New Client</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $database = "dt_crud";
            // Criação da conexão
            $connection = new mysqli($servername, $username, $password, $database);
            // Verifiação de conexão
            if ($connection->connect_error) {
                die("Connection failed " . $connection->connect_error);
            }

            //Ler todas as linhas da tabela no banco de dados que criamos
            $sql = "SELECT * FROM clients";
            $result = $connection->query($sql);

            if (!$result) {
                die("Invalid query " . $connection->connect_error);
            }

            // Ler dados de cada linha.

            while ($row = $result->fetch_assoc()) {
                echo "
    <tbody>
        <tr>
<td>$row[id]</td>
<td>$row[name]</td>
<td>$row[email]</td>
<td>$row[phone]</td>
<td>$row[address]</td>
<td>$row[created_at]</td>
<td>
    <a class= 'btn btn-primary' href='edit.php?id=$row[id]'>Edit</a>
    <a class= 'btn btn-danger' href='delete.php?id=$row[id]'>Delete</a>
</td>
    </tr>
";
            }
            ?>
            </tbody>
        </table>
    </div>

</body>

</html>