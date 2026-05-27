<?php
require 'db.php';

$errors = [];
$data   = ['nome' => '', 'categoria' => '', 'quantidade' => '', 'preco' => '', 'fornecedor' => '', 'data_cadastro' => date('Y-m-d')];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['nome']          = trim($_POST['nome'] ?? '');
    $data['categoria']     = trim($_POST['categoria'] ?? '');
    $data['quantidade']    = trim($_POST['quantidade'] ?? '');
    $data['preco']         = trim(str_replace(',', '.', $_POST['preco'] ?? ''));
    $data['fornecedor']    = trim($_POST['fornecedor'] ?? '');
    $data['data_cadastro'] = trim($_POST['data_cadastro'] ?? '');

    if ($data['nome'] === '')          $errors[] = 'O nome é obrigatório.';
    if ($data['categoria'] === '')     $errors[] = 'A categoria é obrigatória.';
    if (!is_numeric($data['quantidade']) || (int)$data['quantidade'] < 0) $errors[] = 'Quantidade inválida.';
    if (!is_numeric($data['preco'])    || (float)$data['preco'] < 0)      $errors[] = 'Preço inválido.';
    if ($data['fornecedor'] === '')    $errors[] = 'O fornecedor é obrigatório.';
    if ($data['data_cadastro'] === '') $errors[] = 'A data de cadastro é obrigatória.';

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO produtos (nome, categoria, quantidade, preco, fornecedor, data_cadastro) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssidss', $data['nome'], $data['categoria'], $data['quantidade'], $data['preco'], $data['fornecedor'], $data['data_cadastro']);
        if ($stmt->execute()) {
            header('Location: index.php?msg=criado');
            exit;
        }
        $errors[] = 'Erro ao salvar no banco de dados.';
    }
}

$pageTitle = 'Novo Produto';
require 'header.php';
?>

<h1>Novo Produto</h1>

<?php if (!empty($errors)): ?>
  <div class="alert alert-error"><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
<?php endif; ?>

<div class="card">
  <form method="POST" action="create.php">
    <div class="form-grid">

      <div class="form-group">
        <label for="nome">Nome do Produto *</label>
        <input type="text" id="nome" name="nome" maxlength="100" required
               value="<?= htmlspecialchars($data['nome']) ?>" placeholder="Ex: Caneta Esferográfica Azul">
      </div>

      <div class="form-group">
        <label for="categoria">Categoria *</label>
        <input type="text" id="categoria" name="categoria" maxlength="50" required
               value="<?= htmlspecialchars($data['categoria']) ?>" placeholder="Ex: Papelaria">
      </div>

      <div class="form-group">
        <label for="quantidade">Quantidade em Estoque *</label>
        <input type="number" id="quantidade" name="quantidade" min="0" required
               value="<?= htmlspecialchars($data['quantidade']) ?>" placeholder="0">
      </div>

      <div class="form-group">
        <label for="preco">Preço Unitário (R$) *</label>
        <input type="text" id="preco" name="preco" required
               value="<?= htmlspecialchars($data['preco']) ?>" placeholder="0.00">
      </div>

      <div class="form-group">
        <label for="fornecedor">Fornecedor *</label>
        <input type="text" id="fornecedor" name="fornecedor" maxlength="100" required
               value="<?= htmlspecialchars($data['fornecedor']) ?>" placeholder="Ex: Bic do Brasil">
      </div>

      <div class="form-group">
        <label for="data_cadastro">Data de Cadastro *</label>
        <input type="date" id="data_cadastro" name="data_cadastro" required
               value="<?= htmlspecialchars($data['data_cadastro']) ?>">
      </div>

    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Salvar Produto</button>
      <a href="index.php" class="btn btn-cancel">Cancelar</a>
    </div>
  </form>
</div>

<?php require 'footer.php'; ?>
