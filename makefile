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

# Alvo para subir os containers Docker
up:
	@echo "Subindo os containers Docker"
	docker compose up -d

# Alvo para parar os containers Docker
down:
	@echo "Parando os containers Docker"
	docker compose down
