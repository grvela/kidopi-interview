Inicie os serviços em containeres

```bash
sudo docker compose -f docker-compose.yaml -f .docker/compose.dev.yaml up
```

Instale as dependências dentro do container
```bash
sudo docker exec -it app /bin/bash -c "composer install" 
```

Gere a app key do laravel 

```bash
sudo docker exec -it app /bin/bash -c "php artisan key:generate"
```

sudo chmod -R 755 /var/www/html/vendor
sudo chown -R 1000:1000 /var/www/html/vendor
