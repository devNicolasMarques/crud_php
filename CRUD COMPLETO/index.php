<?php
include 'connection.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM livros WHERE id = $id");
    header("Location: index.php");
    exit;
}

if (isset($_POST['update'])) {

    $id = intval($_POST['id']);
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $autor = $conn->real_escape_string($_POST['autor']);
    $ano = intval($_POST['ano']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $quantidade = intval($_POST['quantidade']);

    $sql = "UPDATE livros SET 
                titulo='$titulo',
                autor='$autor',
                ano=$ano,
                categoria='$categoria',
                quantidade=$quantidade
            WHERE id=$id";

    $conn->query($sql);

    header("Location: index.php");
    exit;
}

$termoBusca = "";
$sql = "SELECT * FROM livros ORDER BY id DESC";

if (!empty($_GET['busca'])) {
    $termoBusca = $conn->real_escape_string($_GET['busca']);
    $sql = "SELECT * FROM livros 
            WHERE titulo LIKE '%$termoBusca%' 
               OR categoria LIKE '%$termoBusca%'";
}

$resultado = $conn->query($sql);

$livroEdicao = null;

if (isset($_GET['edit'])) {
    $idEdit = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM livros WHERE id = $idEdit");

    if ($res && $res->num_rows > 0) {
        $livroEdicao = $res->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca — CRUD Completo</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<header>
    <h1>📚 Biblioteca Escolar</h1>
</header>

<div class="container">

    <form class="search-box" method="GET" action="index.php">
        <input type="text" name="busca" placeholder="Pesquisar..." value="<?= htmlspecialchars($termoBusca) ?>">
        <button>Buscar</button>
        <?php if ($termoBusca): ?>
            <a href="index.php" class="btn-clear">Limpar</a>
        <?php endif; ?>
    </form>

    <?php if ($livroEdicao): ?>
        <h2>✏️ Editar Livro</h2>

        <form method="POST" class="edit-form">

            <input type="hidden" name="id" value="<?= $livroEdicao['id'] ?>">

            <label>Título:</label>
            <input type="text" name="titulo" value="<?= $livroEdicao['titulo'] ?>" required>

            <label>Autor:</label>
            <input type="text" name="autor" value="<?= $livroEdicao['autor'] ?>" required>

            <label>Ano:</label>
            <input type="number" name="ano" value="<?= $livroEdicao['ano'] ?>" required>

            <label>Categoria:</label>
            <input type="text" name="categoria" value="<?= $livroEdicao['categoria'] ?>" required>

            <label>Quantidade:</label>
            <input type="number" name="quantidade" value="<?= $livroEdicao['quantidade'] ?>" required>

            <button type="submit" name="update">Salvar</button>
            <a href="index.php" class="btn-cancel">Cancelar</a>
        </form>

        <hr>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Ano</th>
                <th>Categoria</th>
                <th>Qtd.</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while ($livro = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $livro['id'] ?></td>
                    <td><strong><?= $livro['titulo'] ?></strong></td>
                    <td><?= $livro['autor'] ?></td>
                    <td><?= $livro['ano'] ?></td>
                    <td><?= $livro['categoria'] ?></td>
                    <td><?= $livro['quantidade'] ?></td>

                    <td>
                        <a class="btn-edit" href="?edit=<?= $livro['id'] ?>">✏️</a>

                        <a class="btn-delete" 
                           href="?delete=<?= $livro['id'] ?>"
                           onclick="return confirm('Tem certeza que deseja excluir este livro?');">🗑️</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">Nenhum livro encontrado.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>
