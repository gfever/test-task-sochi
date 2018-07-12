FROM percona:latest

COPY docker/dump.sql /docker-entrypoint-initdb.d/db_schema.sql