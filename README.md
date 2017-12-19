> Esta versión está marcada como inestable. Se ha mantenido la versión como ejemplo de Dockerfile

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

## Corre la imagen

```sh
docker run -d --name preguntas -p 80:80 preguntas:latest
docker logs -f preguntas
docker rm -f preguntas
```

