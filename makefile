# Defina as variáveis
MYSQL_PASSWORD=1234
MYSQL_HOST=database
MYSQL_USER=root
MYSQL_DB=db
SQL_FILE=./db_init/init.sql

# Alvo para executar o SQL no Docker MySQL
run_sql:
	@echo "Executando script SQL no MySQL"
	# Passando a senha diretamente no comando
	@docker exec -i micro-framework-database-1 mysql -h $(MYSQL_HOST) -u $(MYSQL_USER) -p$(MYSQL_PASSWORD) $(MYSQL_DB) < $(SQL_FILE)

# Alvo para apagar a tabela users
drop_table:
	@echo "Apagando a tabela users do MySQL"
	@docker exec -i micro-framework-database-1 mysql -h $(MYSQL_HOST) -u $(MYSQL_USER) -p$(MYSQL_PASSWORD) -e "DROP TABLE IF EXISTS users;" $(MYSQL_DB)

# Alvo para inserir dados na tabela users
insert_data:
	@echo "Inserindo dados na tabela users"
	@docker exec -i micro-framework-database-1 mysql -h $(MYSQL_HOST) -u $(MYSQL_USER) -p$(MYSQL_PASSWORD) $(MYSQL_DB) -e "\
		INSERT INTO users (email, nome, data_nascimento) VALUES \
		('joao@example.com', 'João Silva', '1990-05-20'), \
		('maria@example.com', 'Maria Oliveira', '1985-10-15'), \
		('carlos@example.com', 'Carlos Souza', '1993-07-30');"
# Alvo para subir os containers Docker
up:
	@echo "Subindo os containers Docker"
	docker compose up -d

# Alvo para parar os containers Docker
down:
	@echo "Parando os containers Docker"
	docker compose down
