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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $del = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    $del->bind_param('i', $id);
    if ($del->execute()) {
        header('Location: index.php?msg=excluido');
        exit;
    }
}

$pageTitle = 'Excluir Produto';
require 'header.php';
?>

<h1>Excluir Produto</h1>

<div class="card">
  <div class="alert alert-error">
    Você está prestes a excluir permanentemente o produto abaixo. Esta ação não pode ser desfeita.
  </div>

  <table style="margin-bottom:24px">
    <thead>
      <tr>
        <th>#</th><th>Nome</th><th>Categoria</th><th>Quantidade</th><th>Preço</th><th>Fornecedor</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><strong><?= htmlspecialchars($row['nome']) ?></strong></td>
        <td><?= htmlspecialchars($row['categoria']) ?></td>
        <td><?= $row['quantidade'] ?></td>
        <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
        <td><?= htmlspecialchars($row['fornecedor']) ?></td>
      </tr>
    </tbody>
  </table>

  <form method="POST" action="delete.php?id=<?= $id ?>">
    <div class="form-actions">
      <button type="submit" class="btn btn-delete">Confirmar Exclusão</button>
      <a href="index.php" class="btn btn-cancel">Cancelar</a>
    </div>
  </form>
</div>

<?php require 'footer.php'; ?>
