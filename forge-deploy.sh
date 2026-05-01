#!/usr/bin/env bash
set -euo pipefail

# Laravel Forge / Ploi deploy script for this AMS project.
# Run from the project root after fetching/pulling the latest code.

echo "Starting Forge/Ploi deployment for AMS..."

# Ensure PHP dependencies are installed with Flux auth for private packages.
composer config http-basic.composer.fluxui.dev "${FLUX_USERNAME:-}" "${FLUX_LICENSE_KEY:-}"
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Build frontend assets.
npm ci
npm run build

# Copy environment if missing (only for first deploy).
if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate --force
fi

# Ensure APP_KEY is set.
if grep -q "^APP_KEY=$" .env; then
  php artisan key:generate --force
fi

# Run database migrations in production.
php artisan migrate --force

# Cache config/routes/views for production.
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache || true

# Ensure storage symlink exists.
php artisan storage:link || true

echo "Deployment complete."
