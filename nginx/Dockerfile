FROM nginx:alpine

WORKDIR /etc/nginx/html

COPY nginx/nginx.conf /etc/nginx/nginx.conf

COPY app/Public/hello.html .

COPY nginx/certs /etc/nginx/certs