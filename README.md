# Docker Nights 8: ¿Cómo empiezo con Docker?

Esta es una aplicación escrita en PHP y que guarda datos en MongoDB.

## Requisitos del servidor

* Ubuntu 16.04 LTS
* PHP >= 7.0.0
* Mongo PHP Extension
* MongoDB >= 3.6
* PHP Composer

## Instalando Apache, PHP y Mongo

### Apache

```sh
apt-get update
apt-get install apache2 -y
a2enmod rewrite

```

```sh
PUBLIC_IP=$(curl icanhazip.com)

cat > preguntas.conf <<'EOF'
<VirtualHost *:80>
   ServerName PUBLIC_IP
   DocumentRoot /var/www/html
   ErrorLog ${APACHE_LOG_DIR}/preguntas_error.log
   CustomLog ${APACHE_LOG_DIR}/preguntas_access.log combined
   <Directory /var/www/html>
      Options Indexes FollowSymLinks MultiViews
      AllowOverride All
      Require all granted
   </Directory>
</VirtualHost>
EOF

sed -i "s/PUBLIC_IP/${PUBLIC_IP}/" preguntas.conf

mv preguntas.conf /etc/apache2/sites-available/preguntas.conf
a2dissite 000-default.conf
a2ensite preguntas.conf
```

### PHP
```sh
apt-get install php php-dev php-pear zip unzip php7.0-zip pkg-config libapache2-mod-php -y

```

### Mongo PHP Extension

```sh
pecl install mongodb
echo "extension=mongodb.so" > /etc/php/7.0/cli/conf.d/20-mongodb.ini
echo "extension=mongodb.so" > /etc/php/7.0/apache2/conf.d/20-mongodb.ini
```

Reinicia `Apache` para completar la instalación:

```sh
systemctl restart apache2

```

### Mongo Server

```sh
apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 2930ADAE8CAF5059EE73BB4B58712A2291FA4AD5
echo "deb [ arch=amd64,arm64 ] https://repo.mongodb.org/apt/ubuntu xenial/mongodb-org/3.6 multiverse" | sudo tee /etc/apt/sources.list.d/mongodb-org-3.6.list
apt-get update
apt-get install -y mongodb-org

```

Habilita e inicia el servicio de MongoDB en el sistema operativo:

```sh
systemctl enable mongod

```

## Composer

```sh
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php --install-dir=/usr/local/bin/ --filename=composer
php -r "unlink('composer-setup.php');"

```

## Instalando la aplicación

```sh
rm -rf /var/www/html/*
composer install
systemctl restart apache2
```

Visita `http://DIRECCION_IP/` para abrir la aplicación.