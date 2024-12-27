## Introduction
APP URL - http://localhost:8000\
API Documentation - http://localhost:8000/api/documentation

## Installation

Clone repository
```bash
git clone https://github.com/berzins92/lande-home-assigmnent.git
```

Go to project folder and check if `master` branch is up to date
```bash
cd lande-home-assigmnent && git pull origin main
```
___
### Environment (no action needed)

The app uses `8000` port for nginx and `3306` for database.\
Make sure, that other containers are not listening to these ports.\
You can change ports in `.env.example` file.
```bash
APP_PORT=8000
DB_PORT=3306
```
In .env.example file, there is default database connection configuration. Adjust it or use default (no action needed).
```bash
DB_DATABASE=lande-task
DB_USERNAME=laravel
DB_PASSWORD=secret
DB_ROOT_PASSWORD=root
```
___

### Build
Copy env file
```bash
cp .env.example .env
```

Make sure, that Docker is opened and run
```bash
docker-compose build --no-cache && docker-compose up -d
```

Run post-install bash script\
It executes following commands:
- composer install
- php artisan key:generate
- php artisan migrate --force
- php artisan config:clear
- php artisan config:cache
- php artisan route:cache
- php artisan optimize
- php artisan l5-swagger:generate
```bash
bash ./post-install.sh 
```

Test if page is working and you see phpinfo
```bash
http://localhost:8000
```

### Testing
Optional, but recommended to run tests
```bash
docker-compose exec lande-app php artisan test
```

### Final notes
Task built for https://github.com/lande-finance/test-task \
If you have any comments or questions, let me know.\
\
Any feedback would be appreciated.
