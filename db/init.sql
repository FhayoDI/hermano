CREATE DATABASE IF NOT EXISTS stockfacil
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE stockfacil;

CREATE TABLE IF NOT EXISTS produtos (
  id          INT           NOT NULL AUTO_INCREMENT,
  nome        VARCHAR(100)  NOT NULL,
  categoria   VARCHAR(50)   NOT NULL,
  quantidade  INT           NOT NULL DEFAULT 0,
  preco       DECIMAL(10,2) NOT NULL,
  fornecedor  VARCHAR(100)  NOT NULL,
  data_cadastro DATE        NOT NULL DEFAULT (CURDATE()),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO produtos (nome, categoria, quantidade, preco, fornecedor, data_cadastro) VALUES
  ('Caneta Esferográfica Azul',  'Papelaria',    150, 1.50, 'Bic do Brasil',       '2026-01-10'),
  ('Resma de Papel A4 500fls',   'Papelaria',     40, 22.90, 'Chamex Distribuidora', '2026-01-15'),
  ('Grampeador Médio',           'Escritório',    25, 18.00, 'Maped Suprimentos',   '2026-02-01'),
  ('Teclado USB ABNT2',          'Informática',   15, 89.90, 'TechStore Ltda',      '2026-02-10'),
  ('Mouse Óptico USB',           'Informática',   20, 49.90, 'TechStore Ltda',      '2026-02-10'),
  ('Agenda 2026 Capa Dura',      'Papelaria',     30, 35.00, 'Tilibra Atacado',     '2026-03-01'),
  ('Café Torrado 500g',          'Copa/Cozinha',  10, 15.80, 'Melitta Distribuidora','2026-03-05'),
  ('Copo Descartável 200ml c/100','Copa/Cozinha',  8, 9.90,  'Copobras',            '2026-03-05');
