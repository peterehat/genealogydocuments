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
  --exclude='wp-content/ai1wm-backups/' \
  -e "ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts" \
  ./ $SERVER_USER@$SERVER_IP:$SERVER_PATH/

# Copy production wp-config.php
echo "⚙️  Setting up wp-config.php..."
sshpass -p "$SERVER_PASSWORD" scp -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts wp-config-production.php $SERVER_USER@$SERVER_IP:$SERVER_PATH/wp-config.php

# Fix database credentials and security keys in wp-config.php
echo "🔧 Fixing database credentials and security keys..."
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts $SERVER_USER@$SERVER_IP "
  # Fix database credentials
  sed -i \"s/YOUR_DATABASE_HOST/\${DB_HOST:-genealogydocuments-db-do-user-25354054-0.l.db.ondigitalocean.com:25060}/\" $SERVER_PATH/wp-config.php
  sed -i \"s/YOUR_DATABASE_PASSWORD/\${DB_PASSWORD:-AVNS_XP1E14_U_JYFbqaN9l7}/\" $SERVER_PATH/wp-config.php
  
  # Generate and update security keys if they are still placeholders
  if grep -q 'GENERATE_YOUR_OWN_AUTH_KEY' $SERVER_PATH/wp-config.php; then
    echo 'Generating new security keys...'
    curl -s https://api.wordpress.org/secret-key/1.1/salt/ > /tmp/wp-keys.php
    sed -i '/define.*AUTH_KEY/,/define.*NONCE_SALT/c\
define( '\''AUTH_KEY'\'',         '\''|PE{<4W*E7uSd5}HGpAd]JE-pS+Go#>@p7Tp)4:/g0;/g8(]  bKney\$Q:{U2 g{'\'' );\
define( '\''SECURE_AUTH_KEY'\'',  '\''s+Q)Rk2OPy{[.}.zv.t=;lq6Wg~wFou_=>FN@THVr(*]-`nXZZgWu~5Q%yB7Rmqc'\'' );\
define( '\''LOGGED_IN_KEY'\'',    '\''.<`DOU;Q/MbqZU^[\$3Ra.htv~r5<O->)A>:35=uTBxDW#;XppN]YP+ce;wXXOSL+'\'' );\
define( '\''NONCE_KEY'\'',        '\''1X-r=DnAU55_fxGXEunJRC`:c<v@fKW#K=}e/`` 2)&4reLY@l9W.^rRm||R@bc*'\'' );\
define( '\''AUTH_SALT'\'',        '\''!/>z=7N>-Wl=wp>Oe)C-Zdza-R1x`8X9Uvn|n/*Z>_pS@u76}Fp?+anLP_t!ca^x'\'' );\
define( '\''SECURE_AUTH_SALT'\'', '\''~NLaBA<T(z*VmAy):n0mUX@{ti@L0y=&c`&a7Bk|ufJ~@hrPWz?6<>1zijn7,(2M'\'' );\
define( '\''LOGGED_IN_SALT'\'',   '\''Q_Et.K\$px(Q(l=(JTQ8Bn9A\$NTyGA?SyoWeBs*7hV9QH1]Yu!7,{m#bUc.@Pt.(/'\'' );\
define( '\''NONCE_SALT'\'',       '\''N2#Y*y%1D&+E,X<|H1t`2[L,hW/`rXUN{|`fQHSLrO%N7hx)?_-TwN_HEqr&I@;`'\'' );' $SERVER_PATH/wp-config.php
    rm -f /tmp/wp-keys.php
  fi
"

# Set proper permissions
echo "🔐 Setting file permissions..."
sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts $SERVER_USER@$SERVER_IP "
  chown -R www-data:www-data $SERVER_PATH/
  find $SERVER_PATH/ -type d -exec chmod 755 {} +
  find $SERVER_PATH/ -type f -exec chmod 644 {} +
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