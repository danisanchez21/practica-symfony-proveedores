#!/usr/bin/env sh
set -e

# 1) Migraciones
php bin/console doctrine:migrations:migrate --no-interaction

# 2) Fixtures (sólo append)
php bin/console doctrine:fixtures:load --no-interaction --append

# 3) Arranca PHP-FPM
exec php-fpm
