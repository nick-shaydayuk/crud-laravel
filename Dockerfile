# Use the official PHP image as the base image
FROM php:8.3-apache

# Install necessary dependencies
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

# Run migrations
RUN php artisan migrate

# Build frontend assets
RUN export NVM_DIR="$HOME/.nvm" \
    && [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" \
    && npm run build

# Configure Apache
RUN echo '<VirtualHost *:80>\n\
    ServerName localhost\n\
    DocumentRoot /home/nick/crud-laravel/public\n\
    <Directory /home/nick/crud-laravel/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
    </VirtualHost>' > /etc/apache2/sites-available/hexletJob.conf \
    && a2ensite hexletJob \
    && a2enmod rewrite \
    && service apache2 restart

EXPOSE 80
CMD ["apache2-foreground"]