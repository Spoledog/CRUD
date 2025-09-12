<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "sugarbunnies";

// Criação da conexão
$connection = new mysqli($servername, $username, $password, $database);

$id = "";
$image_data = "";
$nome = "";
$nome_jp = "";
$genero = "";
$status = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET mostra os dados do personagem
    if (!isset($_GET["id"])) {
        header("location:index.php");
        exit;
    }

    $id = $_GET["id"];

    // Ler a linha do personagem selecionado no MYSQL
    $sql = "SELECT * FROM lista_personagens WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: index.php");
        exit;
    }
    $image_data = $row["image_data"];
    $nome = $row["nome"];
    $nome_jp = $row["nome_jp"];
    $genero = $row["genero"];
    $status = $row["status"];
} else {
    // POST: Atualizar os dados do personagem
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $nome_jp = $_POST["nome_jp"];
    $genero = $_POST["genero"];
    $status = $_POST["status"];

    // Verifica se uma nova imagem foi enviada
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_data = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $update_image = true;
    } else {
        $update_image = false;
    }

    do {
        if (empty($nome) || empty($nome_jp) || empty($genero) || empty($status)) {
            $errorMessage = "Todos os campos são obrigatórios";
            break;
        }

        if ($update_image) {
            $sql = "UPDATE lista_personagens SET image_data = '$image_data', nome = '$nome', nome_jp = '$nome_jp', genero = '$genero', status = '$status' WHERE id = $id";
        } else {
            $sql = "UPDATE lista_personagens SET nome = '$nome', nome_jp = '$nome_jp', genero = '$genero', status = '$status' WHERE id = $id";
        }

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Personagem atualizado com sucesso!";

        header("location: index.php");
        exit;
    } while (false);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <h2>Editar Personagem</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Imagem atual</label>
                <div class="col-sm-6">
                    <img src="image.php?id=<?php echo $id; ?>" alt="Imagem" style="max-width:150px;max-height:150px;">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nova imagem</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control" name="image" accept="image/*">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nome</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nome" value="<?php echo $nome; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nome (japonês)</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nome_jp" value="<?php echo $nome_jp; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Gênero</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="genero" value="<?php echo $genero; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="status" value="<?php echo $status; ?>">
                </div>
            </div>
            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='row mb-3'>
                <div class='offset-sm-3 col-sm-6'>
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>$successMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                </div>
                </div>
                ";
            }
            ?>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="index.php" role="button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>