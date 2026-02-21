# Desafio Técnico: Sincronização de Produtos e Preços

Este projeto consiste em uma API robusta desenvolvida em **Laravel 11** para realizar o processamento, transformação e sincronização de dados entre bases legadas e tabelas de produção. A solução utiliza **Docker**, **Nginx** e **SQLite**.

## 🧠 Diferenciais e Arquitetura

- **Camada de Transformação (SQL Views):** A inteligência de limpeza de dados (remoção de espaços extras, normalização de strings e conversão de valores monetários brasileiros para decimais) foi implementada diretamente via **Views SQL**, garantindo alta performance e isolamento da lógica de negócio.
- **Resiliência na Sincronização:** Os serviços de sincronização utilizam a estratégia `updateOrInsert` e possuem travas lógicas para garantir a integridade referencial (evitando a inserção de preços para produtos ainda não sincronizados).
- **Compatibilidade Multi-plataforma:** As consultas foram ajustadas com `LOWER`, `UPPER` e `CAST` para garantir que a sensibilidade de caixa (Case Sensitivity) do SQLite no Linux (Docker) não afete os resultados, mantendo a paridade com o ambiente de desenvolvimento.
- **Testes Automatizados:** Suite de testes de feature cobrindo fluxos de sucesso, falha de integridade e listagem paginada.

---

## 🚀 Como Executar o Projeto (Docker)

Siga os passos abaixo no terminal da raiz do projeto:

1. **Subir os containers:**
   ```bash
   docker compose up -d

2. **Instalar dependências (Composer):**
    ```bash
    docker compose exec app composer install

3. **Configurar o ambiente:**
    ```bash
    docker compose exec app cp .env.example .env
    docker compose exec app php artisan key:generate

4. **Preparar Banco de Dados e Permissões:**
    ```bash
    docker compose exec app touch database/database.sqlite
    docker compose exec app chmod -R 777 database storage
    docker compose exec app php artisan migrate:fresh --seed

## 📡 Endpoints da API

A API responde em **http://localhost:8000/api:**

| Método | Endpoint | Descrição |
| :--- | :--- | :--- |
| `POST` | `/api/sincronizar/produtos` | Processa e sincroniza a carga de produtos ativos. |
| `POST` | `/api/sincronizar/precos` | Processa e sincroniza a carga de preços vigentes. |
| `GET` | `/api/produtos-precos` | Retorna a listagem final paginada (Produto + Preço). |

## 🧪 Executando Testes

    ```bash
    docker compose exec app php artisan test
