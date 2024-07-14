# Use the official PHP image as the base image
FROM php:8.3

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  libpq-dev \
  nodejs \
  npm

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd pgsql

# Install Node.js via nvm
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash \
    && export NVM_DIR="$HOME/.nvm" \
    && [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" \
    && nvm install 18 \
    && nvm use 18 \
    && nvm alias default 18 \
    && npm install -g npm

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . /home/nick/crud-laravel

# Set working directory
WORKDIR /home/nick/crud-laravel

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash \
    && export NVM_DIR="$HOME/.nvm" \
    && [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" \
    && nvm install 18 \
    && nvm use 18 \
    && nvm alias default 18 \
    && npm install -g npm
# Install application dependencies
RUN export NVM_DIR="$HOME/.nvm" \
    && [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" \
    && npm install \
    && npm ci \
    && composer install

# Set permissions
RUN chown -R www-data:www-data /home/nick/crud-laravel \
    && chmod -R 777 /home/nick/crud-laravel \
    && php artisan storage:link

# Set up environment and generate application key
RUN cp .env.example .env \
    && mkdir -p database \
    && chown -R www-data:www-data /home/nick/crud-laravel/database \
    && chmod -R 777 /home/nick/crud-laravel/database \
    && php artisan key:generate

RUN php artisan migrate:refresh

RUN npm run build

CMD php artisan serve --host=0.0.0.0 --port=8000