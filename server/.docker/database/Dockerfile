FROM mariadb:10.9.2

# cuando insertamos un sql dentro de docker-entrypoint-initdb.d
# lo que va ha hacer de la imagen va a crer el contenedor
# y va a ejecutar all lo que haya en este fichero sql como crear datos crear dbs etc.
COPY ./databases.sql /docker-entrypoint-initdb.d/databases.sql
