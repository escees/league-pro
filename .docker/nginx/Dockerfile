FROM nginx:alpine

RUN apk update && apk add bash

RUN apk add openssl

RUN mkdir -p /etc/nginx/ssl
RUN chmod -R 600 /etc/nginx/ssl
RUN openssl req -batch -subj '/CN=localhost' -x509 -newkey rsa:4096 -nodes -keyout /etc/nginx/ssl/agat.pem -out /etc/nginx/ssl/agat.pem -days 365
