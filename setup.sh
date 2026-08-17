#!/usr/bin/env bash
set -e

[ -f .env ] || cp .env.example .env

if [ ! -d vendor ]; then
  docker run --rm -v "$(pwd)":/var/www/html -w /var/www/html \
    laravelsail/php83-composer:latest composer install --ignore-platform-reqs
fi

[ -f docker-compose.yml ] || php artisan sail:install --with=mariadb --no-interaction || true

./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm install
./vendor/bin/sail npm run build

echo "Fertig! -> http://localhost"
