<?php
$pageTitle = 'Lista de Produtos';
require 'header.php';
require 'db.php';

$msg = '';
if (!empty($_GET['msg'])) {
    $tipos = ['criado' => 'success', 'atualizado' => 'success', 'excluido' => 'success'];
    $textos = [
        'criado'      => 'Produto cadastrado com sucesso!',
        'atualizado'  => 'Produto atualizado com sucesso!',
        'excluido'    => 'Produto excluído com sucesso!',
    ];
    $key = $_GET['msg'];
    if (isset($textos[$key])) {
        $msg = "<div class='alert alert-{$tipos[$key]}'>{$textos[$key]}</div>";
    }
}

$result = $conn->query("SELECT * FROM produtos ORDER BY data_cadastro DESC, id DESC");
?>

<h1>Produtos em Estoque</h1>

<?= $msg ?>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Quantidade</th>
        <th>Preço Unit.</th>
        <th>Fornecedor</th>
        <th>Cadastro</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
    <?php if ($result->num_rows === 0): ?>
      <tr><td colspan="8" style="text-align:center;padding:24px;color:#94a3b8">Nenhum produto cadastrado.</td></tr>
    <?php else: ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <?php
          $qty = (int)$row['quantidade'];
          if ($qty === 0)       { $badge = 'badge-empty'; $label = 'Sem estoque'; }
          elseif ($qty <= 5)    { $badge = 'badge-low';   $label = 'Estoque baixo'; }
          else                  { $badge = 'badge-ok';    $label = 'OK'; }
        ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><strong><?= htmlspecialchars($row['nome']) ?></strong></td>
          <td><?= htmlspecialchars($row['categoria']) ?></td>
          <td>
            <?= $qty ?>
            <span class="badge <?= $badge ?>"><?= $label ?></span>
          </td>
          <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
          <td><?= htmlspecialchars($row['fornecedor']) ?></td>
          <td><?= date('d/m/Y', strtotime($row['data_cadastro'])) ?></td>
          <td style="white-space:nowrap">
            <a class="btn btn-edit"   href="edit.php?id=<?= $row['id'] ?>">Editar</a>
            <a class="btn btn-delete" href="delete.php?id=<?= $row['id'] ?>">Excluir</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php endif; ?>
    </tbody>
  </table>
</div>

<?php require 'footer.php'; ?>
