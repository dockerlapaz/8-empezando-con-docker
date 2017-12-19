FROM ubuntu:xenial
RUN apt-get update && \
	apt-get install apache2 php php-dev php-pear zip unzip php7.0-zip pkg-config libapache2-mod-php -y && \
	pecl install mongodb && \
	echo "extension=mongodb.so" > /etc/php/7.0/cli/conf.d/20-mongodb.ini && \
	echo "extension=mongodb.so" > /etc/php/7.0/apache2/conf.d/20-mongodb.ini && \
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
	php composer-setup.php --install-dir=/usr/local/bin/ --filename=composer && \
	php -r "unlink('composer-setup.php');" && \
	rm -rf /var/www/html
COPY . /var/www/html
WORKDIR /var/www/html
RUN composer install
EXPOSE 80
CMD ["/usr/sbin/apachectl", "-D","FOREGROUND"]
