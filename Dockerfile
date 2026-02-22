# Imagen base oficial de PHP con Apache preinstalado
# Incluye el servidor web Apache y el intérprete de PHP 8.2
FROM php:8.2-apache

# Copia todos los archivos del proyecto (.) 
# al directorio donde Apache sirve los archivos web dentro del contenedor
# /var/www/html es el directorio raíz por defecto en Apache
COPY . /var/www/html/

# Cambia el propietario de los archivos al usuario de Apache (www-data)
# Esto evita problemas de permisos al ejecutar la aplicación
# Luego asigna permisos 755:
# 7 = lectura, escritura y ejecución para el propietario
# 5 = lectura y ejecución para grupo y otros usuarios
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Expone el puerto 80 del contenedor
# Indica que el servidor web estará escuchando en ese puerto
EXPOSE 80

# Comando por defecto que inicia Apache en primer plano
# Es obligatorio para que el contenedor se mantenga en ejecución
CMD ["apache2-foreground"]