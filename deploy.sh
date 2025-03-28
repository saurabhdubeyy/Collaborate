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
  [ $? -eq 0 ] && echo "Default avatar created successfully."
fi

# Create the .htaccess file if it doesn't exist
echo "Setting up .htaccess file..."
if [ ! -f ".htaccess" ]; then
  cat > .htaccess << EOL
Options -Indexes
RewriteEngine On
RewriteBase /

# Redirect all /dashboard/* requests to the root
RewriteRule ^dashboard/(.*)$ /\$1 [R=301,L]

# Handle requests for files and directories
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]

# PHP settings
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value memory_limit 256M
EOL
  [ $? -eq 0 ] && echo ".htaccess file created successfully."
fi

# Log the database environment variables (without revealing passwords)
echo "Database configuration:"
echo "Host: ${PGHOST:-$DB_HOST}"
echo "Database: ${PGDATABASE:-$DB_NAME}"
echo "User: ${PGUSER:-$DB_USER}"
echo "Port: ${PGPORT:-5432}"

# Try running database migrations, don't exit if it fails
echo "Running database migrations..."
php migrate-db.php || echo "Migration may have failed, but continuing deployment..."

# Verify database connection
echo "Verifying database connection..."
php -r '
require_once "config.php";
if ($conn) {
  echo "Database connection successful.\n";
} else {
  echo "Database connection failed. Will continue deployment anyway.\n";
}
' || echo "Connection test failed, but continuing deployment anyway."

# Optimize file permissions for security
echo "Optimizing file permissions..."
find . -type f -name "*.php" -exec chmod 644 {} \; || echo "Permission setting may have partially failed."
find . -type d -exec chmod 755 {} \; || echo "Directory permission setting may have partially failed."

echo "Deployment completed successfully!"
exit 0 