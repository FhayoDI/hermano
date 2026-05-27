# Roteiro – Vídeo StockFácil (7–12 min)

## Empresa: StockFácil
- **Domínio fictício:** stockfacil.com.br
- **Missão:** Controle de Estoque Inteligente para pequenas e médias empresas

---

## Topologia do Ambiente (REQ12)

```
┌─────────────────────────────────────────────────────────┐
│                  Host / Servidor Docker                   │
│                                                           │
│  ┌─── Rede: frontend ─────────────────────────────────┐  │
│  │  [stockfacil-web : php:8.1-apache] – porta 80:80   │  │
│  └───────────────────────────────────────────────────┬─┘  │
│                                                       │    │
│  ┌─── Rede: backend ─────────────────────────────────┘    │
│  │  [stockfacil-db  : mysql:8.0]  (porta interna 3306)    │
│  │  Volume: mysql_data → /var/lib/mysql                   │
│  └─────────────────────────────────────────────────────┘  │
│                                                           │
│  ┌─── Rede: monitoring ──────────────────────────────┐    │
│  │  [node-exporter]   – métricas do host             │    │
│  │  [prometheus]      – coleta e armazena métricas   │    │
│  │  [grafana]         – porta 3000:3000  (dashboard) │    │
│  └─────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────┘
          ↑ HTTP :80            ↑ HTTP :3000
     Cliente (Navegador)   DevOps (Grafana)
```

**Arquivo `/etc/hosts` no cliente (para simular domínio):**
```
127.0.0.1   stockfacil.com.br
```

---

## Comandos para Subir o Ambiente

```bash
# Clonar/copiar o projeto para o servidor
cd /home/usuario/stockfacil

# Subir todos os contêineres
docker compose up -d --build

# Verificar status
docker compose ps

# Adicionar o domínio fictício (cliente)
echo "127.0.0.1 stockfacil.com.br" | sudo tee -a /etc/hosts

# Acessar a aplicação
# http://stockfacil.com.br

# Acessar o Grafana
# http://localhost:3000  →  admin / grafana123

# Ver logs
docker compose logs -f web
docker compose logs -f db

# Parar sem perder dados
docker compose down

# Parar E apagar tudo (inclusive dados)
docker compose down --rmi all -v
```
