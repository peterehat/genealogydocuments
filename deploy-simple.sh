#!/bin/bash

# Simple WordPress Deployment Script
# Optimized for minimal file transfers and maximum efficiency

set -e

echo "🚀 Starting deployment to Digital Ocean..."

# Configuration
SERVER_IP="${DO_SERVER_IP:-167.71.96.206}"
SERVER_USER="${DO_SERVER_USER:-root}"
SERVER_PASSWORD="${DO_SERVER_PASSWORD}"
SERVER_PATH="/var/www/html"
BACKUP_DIR="/var/backups/wordpress"

# Enable WordPress maintenance mode
echo "🔧 Enabling WordPress maintenance mode..."
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null $SERVER_USER@$SERVER_IP "
  echo '<?php \$upgrading = '$(date +%s)'; ?>' > $SERVER_PATH/.maintenance
"

# Create backup directory if it doesn't exist
echo "📦 Creating backup directory..."
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null $SERVER_USER@$SERVER_IP "mkdir -p $BACKUP_DIR"

# Create backup of current site (only essential files)
echo "💾 Creating backup of current site..."
BACKUP_NAME="backup-$(date +%Y%m%d-%H%M%S)"
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null $SERVER_USER@$SERVER_IP "
  cd $SERVER_PATH
  tar -czf $BACKUP_DIR/$BACKUP_NAME.tar.gz \
    wp-content/themes/ \
    .htaccess \
    wp-config.php \
    index.php \
    wp-*.php 2>/dev/null || true \
    xmlrpc.php 2>/dev/null || true
"

# Upload only essential files to server
echo "📤 Uploading essential files to server..."

# 1. Upload root configuration files
echo "📁 Uploading root configuration files..."
sshpass -p "$SERVER_PASSWORD" rsync -avz \
  --exclude='.git' \
  --exclude='.gitignore' \
  --exclude='deploy.sh' \
  --exclude='deploy-advanced.sh' \
  --exclude='deploy-simple.sh' \
  --exclude='wp-config.php' \
  --exclude='wp-config-sample.php' \
  --exclude='wp-config-production.php' \
  --exclude='wp-admin/' \
  --exclude='wp-includes/' \
  --exclude='wp-content/plugins/' \
  --exclude='wp-content/uploads/' \
  --exclude='wp-content/cache/' \
  --exclude='wp-content/ai1wm-backups/' \
  --exclude='wp-content/upgrade/' \
  --exclude='wp-content/upgrade-temp-backup/' \
  --exclude='wp-content/themes/' \
  -e "sshpass -p $SERVER_PASSWORD ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null" \
  ./ $SERVER_USER@$SERVER_IP:$SERVER_PATH/

# 2. Upload theme files
echo "🎨 Uploading theme files..."
sshpass -p "$SERVER_PASSWORD" rsync -avz \
  --delete \
  -e "sshpass -p $SERVER_PASSWORD ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null" \
  wp-content/themes/ $SERVER_USER@$SERVER_IP:$SERVER_PATH/wp-content/themes/

# Copy production wp-config.php
echo "⚙️  Setting up wp-config.php..."
sshpass -p "$SERVER_PASSWORD" scp -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null wp-config-production.php $SERVER_USER@$SERVER_IP:$SERVER_PATH/wp-config.php

# Copy production .htaccess
echo "⚙️  Setting up .htaccess..."
sshpass -p "$SERVER_PASSWORD" scp -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null .htaccess.remote $SERVER_USER@$SERVER_IP:$SERVER_PATH/.htaccess

# Fix database credentials in wp-config.php
echo "🔧 Fixing database credentials..."
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null $SERVER_USER@$SERVER_IP "
  # Fix database credentials
  sed -i \"s/YOUR_DATABASE_HOST/\${DB_HOST:-genealogydocuments-db-do-user-25354054-0.l.db.ondigitalocean.com:25060}/\" $SERVER_PATH/wp-config.php
  sed -i \"s/YOUR_DATABASE_PASSWORD/\${DB_PASSWORD:-AVNS_XP1E14_U_JYFbqaN9l7}/\" $SERVER_PATH/wp-config.php
"

# Set proper permissions
echo "🔐 Setting file permissions..."
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null $SERVER_USER@$SERVER_IP "
  chown -R www-data:www-data $SERVER_PATH/
  find $SERVER_PATH/ -type d -exec chmod 755 {} +
  find $SERVER_PATH/ -type f -exec chmod 644 {} +
  chmod 644 $SERVER_PATH/wp-config.php
"

# Clear any caches
echo "🧹 Clearing caches..."
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null $SERVER_USER@$SERVER_IP "
  if [ -d '$SERVER_PATH/wp-content/cache' ]; then
    rm -rf $SERVER_PATH/wp-content/cache/*
  fi
"

# Disable WordPress maintenance mode
echo "🔧 Disabling WordPress maintenance mode..."
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null $SERVER_USER@$SERVER_IP "
  rm -f $SERVER_PATH/.maintenance
"

# Test the site
echo "🧪 Testing deployment..."
if curl -f -s https://gendocs.org/ > /dev/null; then
  echo "✅ Deployment successful! Site is accessible."
else
  echo "⚠️  Deployment completed but site test failed. Please check manually."
fi

echo "🎉 Deployment process completed!"
