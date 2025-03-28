#!/bin/bash
# This is the deploy script that will be executed on Render

# Run database migrations
php migrate-db.php

# Create storage directories if they don't exist
mkdir -p uploaded_img
mkdir -p images

# Set proper permissions
chmod -R 755 .
chmod -R 777 uploaded_img
chmod -R 777 images

# Create a default avatar if it doesn't exist
if [ ! -f "images/default-avatar.png" ]; then
  cp default-avatar.png images/default-avatar.png
fi

echo "Deployment completed successfully!" 