<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="IMG/favicon.gif">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
    <title>Personagens</title>
</head>

<body>

    <style>
        :root {
            --primary-color: #B3541E;
            --secondary-color: #ffacacff;
            --accent-color: #FFC6C6;
            --text-color: #362222;
            --background-color: #FFEDED;
        }

        h1,h2,h3,h4,h5,h6,th,label,button {
            font-family: "Hachi Maru Pop", cursive;
            font-weight: 400;
            font-style: normal;
            color: var(--text-color);
        }

        .mainbox {
            border: 30px solid transparent;
            border-image: url(https://solaria.neocities.org/guides/borderimage/whitelace.png) 30 round;
            margin: auto;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            background-image: url("IMG/bg.jpg");
            background-attachment: fixed;
            background-position: bottom;
        }

        button {
            background-color: var(--accent-color);
            color: white;
        }
    </style>

    <div class="container my-5">
        <h2>sugarbunnies</h2>
        <a href="create.php" class="btn btn-primary" role="button">Adicionar personagem</a>
        <br>
        <br>
        <div class="mainbox">
        <table class="table">
            <thead >
    </div>
                <tr>
                    <th>ID</th>
                    <th>foto</th>
                    <th>Nome</th>
                    <th>Nome (japones)</th>
                    <th>genero</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
                
            </thead>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $database = "sugarbunnies";
            // Criação da conexão
            $connection = new mysqli($servername, $username, $password, $database);
            // Verifiação de conexão
            if ($connection->connect_error) {
                die("Connection failed " . $connection->connect_error);
            }
            //Ler todas as linhas da tabela no banco de dados que criamos
            $sql = "SELECT * FROM lista_personagens";
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
<td><img src='image.php?id=$row[id]' style='max-width:80px;max-height:80px;'></td>
<td>$row[nome]</td>
<td>$row[nome_jp]</td>
<td>$row[genero]</td>
<td>$row[status]</td>
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