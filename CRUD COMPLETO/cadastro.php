<?php
require_once 'connection.php';

$mensagem = '';
$tipo_mensagem = '';

$titulo = '';
$autor = '';
$ano = '';
$categoria = '';
$quantidade = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Captura os dados
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $autor = mysqli_real_escape_string($conn, $_POST['autor']);
    $ano = mysqli_real_escape_string($conn, $_POST['ano']);
    $categoria = mysqli_real_escape_string($conn, $_POST['categoria']);
    $quantidade = mysqli_real_escape_string($conn, $_POST['quantidade']);

    // Validação
    if (empty($titulo)) {
        $mensagem = 'O título do livro é obrigatório!';
        $tipo_mensagem = 'erro';
    } elseif (empty($categoria)) {
        $mensagem = 'Selecione uma categoria!';
        $tipo_mensagem = 'erro';
    } else {
        // INSERT no banco
        $sql = "INSERT INTO livros (titulo, autor, ano, categoria, quantidade) 
                VALUES ('$titulo', '$autor', '$ano', '$categoria', '$quantidade')";

        if (mysqli_query($conn, $sql)) {
            $mensagem = 'Livro "' . $titulo . '" cadastrado com sucesso!';
            $tipo_mensagem = 'sucesso';

            // Limpa os campos
            $titulo = '';
            $autor = '';
            $ano = '';
            $categoria = '';
            $quantidade = '';
        } else {
            $mensagem = 'Erro ao cadastrar: ' . mysqli_error($conn);
            $tipo_mensagem = 'erro';
        }
    }
}

// Categorias
$categorias = array('Romance', 'Didático', 'Fantasia', 'Ficção Científica', 'História', 'Biografia', 'Autoajuda', 'Infantil');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Livro - Biblioteca Escolar</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>

    <header class="header">
        <h1>Biblioteca Escolar</h1>
        <a href="index.php" class="btn-voltar">
            📚 Ver Acervo
        </a>
    </header>

    <div class="container">

        <div class="cadastro-card">

            <div class="cadastro-icon">📖</div>
            <h2>Cadastrar Novo Livro</h2>
            <p class="cadastro-subtitulo">Preencha as informações do livro abaixo</p>

            <?php if ($mensagem != ''): ?>
                <div class="mensagem <?php echo $tipo_mensagem; ?>">
                    <span class="mensagem-icon">
                        <?php if ($tipo_mensagem == 'sucesso'): ?>
                            ✅
                        <?php else: ?>
                            ❌
                        <?php endif; ?>
                    </span>
                    <span class="mensagem-texto">
                        <?php echo $mensagem; ?>
                    </span>
                </div>
            <?php endif; ?>

            <form method="POST" action="">

                <div class="form-group">
                    <label for="titulo">
                        <span class="label-icon">📕</span>
                        Título do Livro <span class="obrigatorio">*</span>
                    </label>
                    <input
                        type="text"
                        id="titulo"
                        name="titulo"
                        placeholder="Ex: Dom Casmurro"
                        value="<?php echo $titulo; ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="autor">
                        <span class="label-icon">✍️</span>
                        Autor
                    </label>
                    <input
                        type="text"
                        id="autor"
                        name="autor"
                        placeholder="Ex: Machado de Assis"
                        value="<?php echo $autor; ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ano">
                            <span class="label-icon">📅</span>
                            Ano de Publicação
                        </label>
                        <input
                            type="number"
                            id="ano"
                            name="ano"
                            placeholder="Ex: 1899"
                            min="1000"
                            max="2099"
                            value="<?php echo $ano; ?>">
                    </div>

                    <div class="form-group">
                        <label for="quantidade">
                            <span class="label-icon">📦</span>
                            Quantidade
                        </label>
                        <input
                            type="number"
                            id="quantidade"
                            name="quantidade"
                            placeholder="Ex: 5"
                            min="0"
                            value="<?php echo $quantidade; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="categoria">
                        <span class="label-icon">🏷️</span>
                        Categoria <span class="obrigatorio">*</span>
                    </label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Selecione uma categoria...</option>
                        <?php for ($i = 0; $i < count($categorias); $i++): ?>
                            <option value="<?php echo $categorias[$i]; ?>"
                                <?php if ($categoria == $categorias[$i]) echo 'selected'; ?>>
                                <?php echo $categorias[$i]; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-cadastrar-form">
                        💾 Cadastrar Livro
                    </button>
                    <button type="reset" class="btn-limpar-form">
                        🗑️ Limpar
                    </button>
                </div>

            </form>

            <div class="form-dica">
                <span>💡</span>
                <p>Campos marcados com <span class="obrigatorio">*</span> são obrigatórios.</p>
            </div>

        </div>

    </div>

</body>

</html>