#!/bin/bash

# WordPress Deployment Script for Digital Ocean
# This script is used by GitHub Actions to deploy the site

set -e

echo "🚀 Starting deployment to Digital Ocean..."

# Configuration
SERVER_IP="167.71.96.206"
SERVER_USER="root"
SERVER_PATH="/var/www/html"
BACKUP_DIR="/var/backups/wordpress"

# Create backup directory if it doesn't exist
echo "📦 Creating backup directory..."
ssh -o StrictHostKeyChecking=no $SERVER_USER@$SERVER_IP "mkdir -p $BACKUP_DIR"

# Create backup of current site
echo "💾 Creating backup of current site..."
BACKUP_NAME="backup-$(date +%Y%m%d-%H%M%S)"
ssh -o StrictHostKeyChecking=no $SERVER_USER@$SERVER_IP "tar -czf $BACKUP_DIR/$BACKUP_NAME.tar.gz -C $SERVER_PATH ."

# Upload files to server
echo "📤 Uploading files to server..."
rsync -avz --delete \
  --exclude='.git' \
  --exclude='.gitignore' \
  --exclude='deploy.sh' \
  --exclude='wp-config.php' \
  --exclude='wp-content/uploads/' \
  --exclude='wp-content/cache/' \
  ./ $SERVER_USER@$SERVER_IP:$SERVER_PATH/

# Copy production wp-config.php
echo "⚙️  Setting up wp-config.php..."
scp -o StrictHostKeyChecking=no wp-config-production.php $SERVER_USER@$SERVER_IP:$SERVER_PATH/wp-config.php

# Set proper permissions
echo "🔐 Setting file permissions..."
ssh -o StrictHostKeyChecking=no $SERVER_USER@$SERVER_IP "
  chown -R www-data:www-data $SERVER_PATH/
  chmod -R 755 $SERVER_PATH/
  chmod 644 $SERVER_PATH/wp-config.php
"

# Clear any caches
echo "🧹 Clearing caches..."
ssh -o StrictHostKeyChecking=no $SERVER_USER@$SERVER_IP "
  if [ -d '$SERVER_PATH/wp-content/cache' ]; then
    rm -rf $SERVER_PATH/wp-content/cache/*
  fi
"

# Test the site
echo "🧪 Testing deployment..."
if curl -f -s https://gendocs.org/ > /dev/null; then
  echo "✅ Deployment successful! Site is accessible."
else
  echo "❌ Deployment failed! Site is not accessible."
  exit 1
fi

echo "🎉 Deployment completed successfully!"
echo "📊 Backup created: $BACKUP_NAME.tar.gz"
