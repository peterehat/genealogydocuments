#!/bin/bash

# Exit immediately if a command exits with a non-zero status.
set -e

echo "🚀 Starting deployment to Digital Ocean..."

# Configuration
SERVER_IP="${DO_SERVER_IP:-167.71.96.206}"
SERVER_USER="${DO_SERVER_USER:-root}"
SERVER_PASSWORD="${DO_SERVER_PASSWORD}"
SERVER_PATH="/var/www/html"
BACKUP_DIR="/var/backups/wordpress"

# Create SSH directory and known_hosts file
echo "🔑 Setting up SSH configuration..."
mkdir -p ~/.ssh
touch ~/.ssh/known_hosts
chmod 600 ~/.ssh/known_hosts

# Add server to known hosts
echo "🔑 Adding server to known hosts..."
ssh-keyscan -H $SERVER_IP >> ~/.ssh/known_hosts 2>/dev/null || true

# Create backup directory if it doesn't exist
echo "📦 Creating backup directory..."
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts $SERVER_USER@$SERVER_IP "mkdir -p $BACKUP_DIR"

# Create backup of current site
echo "💾 Creating backup of current site..."
BACKUP_NAME="backup-$(date +%Y%m%d-%H%M%S)"
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts $SERVER_USER@$SERVER_IP "tar -czf $BACKUP_DIR/$BACKUP_NAME.tar.gz -C $SERVER_PATH ."

# Upload files to server
echo "📤 Uploading files to server..."
sshpass -p "$SERVER_PASSWORD" rsync -avz --delete \
  --exclude='.git' \
  --exclude='.gitignore' \
  --exclude='deploy.sh' \
  --exclude='wp-config.php' \
  --exclude='wp-content/uploads/' \
  --exclude='wp-content/cache/' \
  -e "ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts" \
  ./ $SERVER_USER@$SERVER_IP:$SERVER_PATH/

# Copy production wp-config.php
echo "⚙️  Setting up wp-config.php..."
sshpass -p "$SERVER_PASSWORD" scp -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts wp-config-production.php $SERVER_USER@$SERVER_IP:$SERVER_PATH/wp-config.php

# Set proper permissions
echo "🔐 Setting file permissions..."
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts $SERVER_USER@$SERVER_IP "
  chown -R www-data:www-data $SERVER_PATH/
  chmod -R 755 $SERVER_PATH/
  chmod 644 $SERVER_PATH/wp-config.php
"

# Clear any caches
echo "🧹 Clearing caches..."
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts $SERVER_USER@$SERVER_IP "
  if [ -d '$SERVER_PATH/wp-content/cache' ]; then
    rm -rf $SERVER_PATH/wp-content/cache/*
  fi
"

# Test the site
echo "🧪 Testing deployment..."
if curl -f -s https://gendocs.org/ > /dev/null; then
  echo "✅ Deployment successful! Site is accessible."
else
  echo "⚠️  Deployment completed but site test failed. Please check manually."
fi

echo "🎉 Deployment process completed!"