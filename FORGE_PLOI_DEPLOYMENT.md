# Laravel Forge / Ploi Deployment

This repository is a Laravel 12 app using Livewire Flux and private Flux Pro packages. Use this guide for deploying on Laravel Forge or Ploi.

## 1. Server requirements

- PHP 8.2
- Composer
- Node.js and npm
- MySQL / MariaDB (or PostgreSQL if configured)
- Git
- `public/` as the web root

## 2. Environment variables

Set these values in Forge/Ploi dashboard:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://your-domain.com`
- `APP_KEY` (generated during first deploy)
- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=AMS_db`
- `DB_USERNAME=root`
- `DB_PASSWORD=1234`
- `SESSION_DRIVER=database`
- `CACHE_STORE=database`
- `QUEUE_CONNECTION=database`
- `FILESYSTEM_DISK=local`
- `MAIL_MAILER=smtp` or `log`
- `MAIL_HOST`
- `MAIL_PORT`
- `MAIL_USERNAME`
- `MAIL_PASSWORD`
- `MAIL_FROM_ADDRESS`
- `MAIL_FROM_NAME`
- `FLUX_USERNAME` (for private Flux composer repo)
- `FLUX_LICENSE_KEY`

If you use Redis instead of database-backed sessions/queues, set `SESSION_DRIVER=redis` and `QUEUE_CONNECTION=redis`.

## 3. Deployment commands

Use this script from the project root:

```bash
bash forge-deploy.sh
```

Alternatively, use the following commands in Forge/Ploi deploy hook:

```bash
composer config http-basic.composer.fluxui.dev "$FLUX_USERNAME" "$FLUX_LICENSE_KEY"
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
npm ci
npm run build

if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate --force
fi

php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache || true
php artisan storage:link || true
```

## 4. Forge-specific setup

1. Create a new site in Laravel Forge.
2. Point the site to the repository branch.
3. Set the web directory to `public`.
4. Add environment variables in Forge "Environment" settings.
5. Use the deploy command above under "Deploy Script".

## 5. Ploi-specific setup

1. Add the server and site in Ploi.
2. Configure the deployment repository and branch.
3. Set `public/` as the web root.
4. Add the environment variables in Ploi site settings.
5. Paste the same deploy commands into the deploy hook.

## 6. Notes

- This project uses a private package repository for `livewire/flux-pro`, so `FLUX_USERNAME` and `FLUX_LICENSE_KEY` must be available during deploy.
- `php artisan storage:link` only needs to run once, but it is safe to leave in the deploy script.
- If your app uses queues, configure a worker in Forge/Ploi using `php artisan queue:work --tries=3` or supervisor.

## 7. Recommended first deploy checklist

- [ ] Push code to a Git repository
- [ ] Add the site in Forge or Ploi
- [ ] Set `public/` as the web root
- [ ] Add all environment variables
- [ ] Run the deploy script
- [ ] Visit the site and confirm login page loads
