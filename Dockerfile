
# Use official PHP image
FROM php:8.2-cli

# Set working directory inside the container
WORKDIR /app

# Copy all project files into the container
COPY . .

# Install PHP extensions if needed (uncomment if using them)
# RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose port Render will connect to
EXPOSE 10000

# Start PHP's built-in development server
CMD ["php", "-S", "0.0.0.0:10000"]
