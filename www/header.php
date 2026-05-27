<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StockFácil – <?= htmlspecialchars($pageTitle ?? 'Controle de Estoque') ?></title>
  <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

<header>
  <a href="/index.php">
    <img src="/assets/logo.svg" alt="StockFácil – Controle de Estoque Inteligente">
  </a>
  <nav>
    <a href="/index.php"    class="<?= $currentPage === 'index.php'  ? 'active' : '' ?>">Produtos</a>
    <a href="/create.php"   class="<?= $currentPage === 'create.php' ? 'active' : '' ?>">+ Novo Produto</a>
  </nav>
</header>

<main>
