<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "sugarbunnies";

$connection = new mysqli($servername, $username, $password, $database);

$nome = "";
$nome_jp = "";
$genero = "";
$status = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nome"];
    $nome_jp = $_POST["nome_jp"];
    $genero = $_POST["genero"];
    $status = $_POST["status"];

    // Verifica se o arquivo foi enviado
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_data = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    } else {
        $image_data = "";
    }

    do {
        if (empty($image_data) || empty($nome) || empty($nome_jp) || empty($genero) || empty($status)) {
            $errorMessage = "Todos os campos são obrigatórios";
            break;
        }

        // Corrige a vírgula no SQL
        $sql = "INSERT INTO lista_personagens (image_data, nome, nome_jp, genero, status) VALUES ('$image_data', '$nome', '$nome_jp', '$genero', '$status')";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Query inválida: " . $connection->error;
            break;
        }

        $image_data = "";
        $nome = "";
        $nome_jp = "";
        $genero = "";
        $status = "";

        $successMessage = "Personagem adicionado com sucesso!";

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
    <title>Adicionar personagem</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <h2>Adicionar Personagem</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>

        <!-- Corrige o enctype e remove forms aninhados -->
        <form method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Imagem</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(event)">
                    <img id="preview" src="no-image.png" style="max-width:120px;max-height:120px;margin-top:10px;">
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
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="index.php" role="button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('preview').src = URL.createObjectURL(file);
            }
        }
    </script>
</body>

</html>