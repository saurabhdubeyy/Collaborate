#!/bin/bash
# Improved deployment script for Collaborate project

set -e # Exit immediately if a command exits with a non-zero status

echo "Starting deployment process..."

# Create storage directories if they don't exist
echo "Setting up storage directories..."
mkdir -p uploaded_img images
chmod -R 755 .
chmod -R 777 uploaded_img images

# Create a default avatar if it doesn't exist
echo "Setting up default avatar..."
if [ ! -f "images/default-avatar.png" ]; then
  cp default-avatar.png images/default-avatar.png
fi

# Run database migrations
echo "Running database migrations..."
php migrate-db.php

# Verify database connection
echo "Verifying database connection..."
php -r '
require_once "config.php";
if ($conn) {
  echo "Database connection successful.\n";
} else {
  echo "Database connection failed. Please check your configuration.\n";
  exit(1);
}
'

# Optimize file permissions for security
echo "Optimizing file permissions..."
find . -type f -name "*.php" -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

echo "Deployment completed successfully!"
exit 0 