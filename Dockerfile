FROM php:8.3.9-fpm

RUN apt-get update && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd pgsql

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash \
  && export NVM_DIR="$HOME/.nvm" \
  && [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" \
  && nvm install 18 \
  && nvm use 18 \
  && nvm alias default 18 \
  && npm install -g npm 

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN export NVM_DIR="$HOME/.nvm" \
  && [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" \
  && npm install \
  && npm ci \
  && composer install

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 777 /var/www/html
RUN php artisan storage:link

RUN cp .env.example .env \
  && php artisan key:generate

RUN export NVM_DIR="$HOME/.nvm" \
  && [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" \
  && npm run build