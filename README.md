# Docker Nights 8: ¿Cómo empiezo con Docker?

Esta es una aplicación escrita en PHP y que guarda datos en MongoDB.

## Requisitos del servidor

* Ubuntu 16.04 LTS
* PHP >= 7.0.0
* Mongo PHP Extension
* MongoDB >= 3.6
* PHP Composer

# Docker >= 17.06

## Construyendo la imagen

```sh
docker build -t preguntas .
```

## Creando un contendor e imagenes

```sh
docker network create preguntas
docker run -d --name mongo --network preguntas mongo:3.6
docker run -d --network -e DB_ADDRESS=mongodb://mongo:27017 --name preguntas -p 80:80 preguntas

```

