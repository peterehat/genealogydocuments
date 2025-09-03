#!/bin/bash

# Advanced WordPress Deployment Script
# Optimized for minimal file transfers and maximum efficiency

set -e

echo "🚀 Starting advanced deployment to Digital Ocean..."

# Configuration
SERVER_IP="${DO_SERVER_IP:-167.71.96.206}"
SERVER_USER="${DO_SERVER_USER:-root}"
SERVER_PASSWORD="${DO_SERVER_PASSWORD}"
SERVER_PATH="/var/www/html"
BACKUP_DIR="/var/backups/wordpress"
ACTIVE_THEME="hello-theme-child-master"  # Change this to your active theme

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if required environment variables are set
check_requirements() {
    print_status "Checking requirements..."
    
    if [ -z "$SERVER_PASSWORD" ]; then
        print_error "DO_SERVER_PASSWORD environment variable is required"
        exit 1
    fi
    
    if [ ! -f "wp-config-production.php" ]; then
        print_error "wp-config-production.php not found"
        exit 1
    fi
    
    if [ ! -f ".htaccess.remote" ]; then
        print_error ".htaccess.remote not found"
        exit 1
    fi
    
    print_success "Requirements check passed"
}

# Setup SSH connection
setup_ssh() {
    print_status "Setting up SSH configuration..."
    mkdir -p ~/.ssh
    touch ~/.ssh/known_hosts
    chmod 600 ~/.ssh/known_hosts
    ssh-keyscan -H $SERVER_IP >> ~/.ssh/known_hosts 2>/dev/null || true
    print_success "SSH configuration complete"
}

# Create selective backup
create_backup() {
    print_status "Creating selective backup..."
    sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts $SERVER_USER@$SERVER_IP "mkdir -p $BACKUP_DIR"
    
    BACKUP_NAME="backup-$(date +%Y%m%d-%H%M%S)"
    sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts $SERVER_USER@$SERVER_IP "
        tar -czf $BACKUP_DIR/$BACKUP_NAME.tar.gz \
            -C $SERVER_PATH \
            wp-content/themes/ \
            .htaccess \
            wp-config.php \
            index.php \
            wp-*.php \
            xmlrpc.php
    "
    print_success "Backup created: $BACKUP_NAME.tar.gz"
}

# Deploy root files (excluding WordPress core)
deploy_root_files() {
    print_status "Deploying root configuration files..."
    
    # Create a temporary directory with only the files we want to deploy
    TEMP_DIR=$(mktemp -d)
    
    # Copy only essential root files
    cp index.php "$TEMP_DIR/"
    cp wp-*.php "$TEMP_DIR/" 2>/dev/null || true
    cp xmlrpc.php "$TEMP_DIR/" 2>/dev/null || true
    cp license.txt "$TEMP_DIR/" 2>/dev/null || true
    cp readme.html "$TEMP_DIR/" 2>/dev/null || true
    
    # Deploy root files
    sshpass -p "$SERVER_PASSWORD" rsync -avz \
        --delete \
        -e "ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts" \
        "$TEMP_DIR/" $SERVER_USER@$SERVER_IP:$SERVER_PATH/
    
    # Cleanup
    rm -rf "$TEMP_DIR"
    print_success "Root files deployed"
}

# Deploy theme files
deploy_theme() {
    print_status "Deploying theme files..."
    
    if [ ! -d "wp-content/themes/$ACTIVE_THEME" ]; then
        print_warning "Active theme '$ACTIVE_THEME' not found, deploying all themes"
        sshpass -p "$SERVER_PASSWORD" rsync -avz \
            --delete \
            -e "ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts" \
            wp-content/themes/ $SERVER_USER@$SERVER_IP:$SERVER_PATH/wp-content/themes/
    else
        print_status "Deploying only active theme: $ACTIVE_THEME"
        sshpass -p "$SERVER_PASSWORD" rsync -avz \
            --delete \
            -e "ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts" \
            "wp-content/themes/$ACTIVE_THEME/" $SERVER_USER@$SERVER_IP:$SERVER_PATH/wp-content/themes/$ACTIVE_THEME/
    fi
    
    print_success "Theme files deployed"
}

# Setup configuration files
setup_config() {
    print_status "Setting up configuration files..."
    
    # Copy production wp-config.php
    sshpass -p "$SERVER_PASSWORD" scp -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts wp-config-production.php $SERVER_USER@$SERVER_IP:$SERVER_PATH/wp-config.php
    
    # Copy production .htaccess
    sshpass -p "$SERVER_PASSWORD" scp -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts .htaccess.remote $SERVER_USER@$SERVER_IP:$SERVER_PATH/.htaccess
    
    print_success "Configuration files set up"
}

# Fix database credentials and security keys
fix_wp_config() {
    print_status "Fixing database credentials and security keys..."
    
    sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts $SERVER_USER@$SERVER_IP "
        # Fix database credentials
        sed -i \"s/YOUR_DATABASE_HOST/\${DB_HOST:-genealogydocuments-db-do-user-25354054-0.l.db.ondigitalocean.com:25060}/\" $SERVER_PATH/wp-config.php
        sed -i \"s/YOUR_DATABASE_PASSWORD/\${DB_PASSWORD:-AVNS_XP1E14_U_JYFbqaN9l7}/\" $SERVER_PATH/wp-config.php
        
        # Generate and update security keys if they are still placeholders
        # Generate and update security keys if they are still placeholders
        if grep -q "GENERATE_YOUR_OWN_AUTH_KEY" $SERVER_PATH/wp-config.php; then
            echo "Generating new security keys..."
            curl -s https://api.wordpress.org/secret-key/1.1/salt/ > /tmp/wp-keys.php
            sed -i "/define.*AUTH_KEY/,/define.*NONCE_SALT/d" $SERVER_PATH/wp-config.php
            cat /tmp/wp-keys.php >> $SERVER_PATH/wp-config.php
            rm -f /tmp/wp-keys.php
        fi    print_success "WordPress configuration updated"
}

# Set proper permissions
set_permissions() {
    print_status "Setting file permissions..."
    
    sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts $SERVER_USER@$SERVER_IP "
        chown -R www-data:www-data $SERVER_PATH/
        find $SERVER_PATH/ -type d -exec chmod 755 {} +
        find $SERVER_PATH/ -type f -exec chmod 644 {} +
        chmod 644 $SERVER_PATH/wp-config.php
    "
    
    print_success "File permissions set"
}

# Clear caches
clear_caches() {
    print_status "Clearing caches..."
    
    sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts $SERVER_USER@$SERVER_IP "
        # Clear WordPress cache
        if [ -d '$SERVER_PATH/wp-content/cache' ]; then
            rm -rf $SERVER_PATH/wp-content/cache/*
        fi
        
        # Clear any plugin caches
        if [ -d '$SERVER_PATH/wp-content/plugins' ]; then
            find $SERVER_PATH/wp-content/plugins -name 'cache' -type d -exec rm -rf {} + 2>/dev/null || true
        fi
        
        # Clear opcache if available
        if command -v php >/dev/null 2>&1; then
            php -r 'if (function_exists(\"opcache_reset\")) { opcache_reset(); echo \"OPcache cleared\"; } else { echo \"OPcache not available\"; }'
        fi
    "
    
    print_success "Caches cleared"
}

# Test deployment
test_deployment() {
    print_status "Testing deployment..."
    
    if curl -f -s https://gendocs.org/ > /dev/null; then
        print_success "Deployment successful! Site is accessible."
        return 0
    else
        print_warning "Deployment completed but site test failed. Please check manually."
        return 1
    fi
}

# Cleanup old backups
cleanup_backups() {
    print_status "Cleaning up old backups (keeping last 5)..."
    
    sshpass -p "$SERVER_PASSWORD" ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=~/.ssh/known_hosts $SERVER_USER@$SERVER_IP "
        cd $BACKUP_DIR
        ls -t backup-*.tar.gz | tail -n +6 | xargs -r rm -f
    "
    
    print_success "Old backups cleaned up"
}

# Main deployment function
main() {
    echo "=========================================="
    echo "🚀 Advanced WordPress Deployment Script"
    echo "=========================================="
    
    check_requirements
    setup_ssh
    create_backup
    deploy_root_files
    deploy_theme
    setup_config
    fix_wp_config
    set_permissions
    clear_caches
    cleanup_backups
    
    if test_deployment; then
        echo "=========================================="
        print_success "🎉 Deployment completed successfully!"
        echo "=========================================="
    else
        echo "=========================================="
        print_warning "⚠️  Deployment completed with warnings"
        echo "=========================================="
        exit 1
    fi
}

# Run main function
main "$@"
