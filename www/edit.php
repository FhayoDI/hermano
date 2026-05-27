<?php
require 'db.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    header('Location: index.php');
    exit;
}

$errors = [];
$data   = $row;

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
        $upd = $conn->prepare("UPDATE produtos SET nome=?, categoria=?, quantidade=?, preco=?, fornecedor=?, data_cadastro=? WHERE id=?");
        $upd->bind_param('ssidssi', $data['nome'], $data['categoria'], $data['quantidade'], $data['preco'], $data['fornecedor'], $data['data_cadastro'], $id);
        if ($upd->execute()) {
            header('Location: index.php?msg=atualizado');
            exit;
        }
        $errors[] = 'Erro ao atualizar no banco de dados.';
    }
}

$pageTitle = 'Editar Produto';
require 'header.php';
?>

<h1>Editar Produto <span style="color:#2563eb">#<?= $id ?></span></h1>

<?php if (!empty($errors)): ?>
  <div class="alert alert-error"><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
<?php endif; ?>

<div class="card">
  <form method="POST" action="edit.php?id=<?= $id ?>">
    <div class="form-grid">

      <div class="form-group">
        <label for="nome">Nome do Produto *</label>
        <input type="text" id="nome" name="nome" maxlength="100" required
               value="<?= htmlspecialchars($data['nome']) ?>">
      </div>

      <div class="form-group">
        <label for="categoria">Categoria *</label>
        <input type="text" id="categoria" name="categoria" maxlength="50" required
               value="<?= htmlspecialchars($data['categoria']) ?>">
      </div>

      <div class="form-group">
        <label for="quantidade">Quantidade em Estoque *</label>
        <input type="number" id="quantidade" name="quantidade" min="0" required
               value="<?= htmlspecialchars($data['quantidade']) ?>">
      </div>

      <div class="form-group">
        <label for="preco">Preço Unitário (R$) *</label>
        <input type="text" id="preco" name="preco" required
               value="<?= htmlspecialchars($data['preco']) ?>">
      </div>

      <div class="form-group">
        <label for="fornecedor">Fornecedor *</label>
        <input type="text" id="fornecedor" name="fornecedor" maxlength="100" required
               value="<?= htmlspecialchars($data['fornecedor']) ?>">
      </div>

      <div class="form-group">
        <label for="data_cadastro">Data de Cadastro *</label>
        <input type="date" id="data_cadastro" name="data_cadastro" required
               value="<?= htmlspecialchars($data['data_cadastro']) ?>">
      </div>

    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Salvar Alterações</button>
      <a href="index.php" class="btn btn-cancel">Cancelar</a>
    </div>
  </form>
</div>

<?php require 'footer.php'; ?>
