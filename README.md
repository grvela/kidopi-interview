# Kidopi Interview 🎤💻

A project for the Kidopi interview about COVID-19 data sources.

## Technologies 🚀

- **Backend**: Laravel 🦄
- **Database**: MySQL 🗃️
- **DevOps**: Docker 🐳, Traefik 🌐
- **Docs**: Swagger 📖

## Setting up Development Environment 🛠️

### 1. Clone the repo

```bash
git clone https://github.com/grvela/kidopi-interview.git

cd kidopi-interview
```

### 2. Run containers 🏃‍♂️
```bash
sudo docker compose -f docker-compose.yaml -f .docker/compose.dev.yaml up
```

### 3. Install dependencies and configure environment ⚙️
```bash
cat .env.example > .env

sudo docker exec -it kidopi-app /bin/bash 

#/var/www/html

composer install

php artisan key:generate

php artisan migrate
```

### 4. Set permissions 🔒
```bash
chmod -R 755 /var/www/html/vendor
chown -R 1000:1000 /var/www/html/vendor
```