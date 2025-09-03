# WordPress Deployment Guide

This repository contains optimized deployment scripts for WordPress that minimize file transfers and deployment time.

## 🚀 Quick Start

### Prerequisites

1. **Server Access**: SSH access to your Digital Ocean server
2. **Environment Variables**: Set up the required environment variables
3. **GitHub Secrets**: Configure repository secrets for automated deployment

### Environment Variables

Create a `.env` file or set these environment variables:

```bash
DO_SERVER_IP=167.71.96.206
DO_SERVER_USER=root
DO_SERVER_PASSWORD=your_password_here
```

## 📁 What Gets Deployed

### ✅ Files That ARE Deployed

**Root Configuration Files:**
- `index.php`
- `wp-*.php` (WordPress core files)
- `xmlrpc.php`
- `license.txt`
- `readme.html`

**Theme Files:**
- `wp-content/themes/` (only active theme by default)

**Configuration Files:**
- `wp-config-production.php` → `wp-config.php`
- `.htaccess.remote` → `.htaccess`

### ❌ Files That Are NOT Deployed

**WordPress Core (managed by server):**
- `wp-admin/`
- `wp-includes/`
- `wp-content/plugins/`

**User Content (managed by server):**
- `wp-content/uploads/`
- `wp-content/cache/`
- `wp-content/ai1wm-backups/`

## 🛠️ Deployment Scripts

### 1. Basic Deployment (`deploy.sh`)

Simple deployment script for quick deployments:

```bash
chmod +x deploy.sh
./deploy.sh
```

### 2. Advanced Deployment (`deploy-advanced.sh`)

Feature-rich deployment script with:

- ✅ Colored output and progress indicators
- ✅ Selective backups
- ✅ Cache clearing
- ✅ Permission management
- ✅ Deployment testing
- ✅ Old backup cleanup
- ✅ Error handling

```bash
chmod +x deploy-advanced.sh
./deploy-advanced.sh
```

## 🤖 GitHub Actions

### Setup

1. **Add Repository Secrets:**
   - `SERVER_SSH_KEY`: Your private SSH key
   - `SERVER_IP`: Your server IP address
   - `SERVER_USER`: Your server username
   - `SERVER_PASSWORD`: Your server password

2. **Automatic Deployment:**
   - Pushes to `main` branch trigger automatic deployment
   - Manual deployment available via GitHub Actions tab

### Manual Deployment Options

When triggering manual deployment, you can choose:

- **Skip Backup**: Skip creating a backup (faster deployment)
- **Deploy All Themes**: Deploy all themes instead of just the active one

## ⚙️ Configuration

### Theme Configuration

Edit the `ACTIVE_THEME` variable in `deploy-advanced.sh`:

```bash
ACTIVE_THEME="hello-theme-child-master"  # Change to your active theme
```

### Database Configuration

Update database credentials in `wp-config-production.php`:

```php
define('DB_HOST', 'your-database-host');
define('DB_PASSWORD', 'your-database-password');
```

## 🔧 Advanced Features

### Selective Theme Deployment

By default, only the active theme is deployed. To deploy all themes:

```bash
DEPLOY_ALL_THEMES=true ./deploy-advanced.sh
```

### Skip Backup

For faster deployments (not recommended for production):

```bash
SKIP_BACKUP=true ./deploy-advanced.sh
```

### Custom Server Path

Deploy to a different server path:

```bash
SERVER_PATH="/var/www/custom-path" ./deploy-advanced.sh
```

## 📊 Performance Benefits

### Before Optimization
- **Deployment Time**: ~5-10 minutes
- **Files Transferred**: ~2000+ files
- **Transfer Size**: ~50-100MB

### After Optimization
- **Deployment Time**: ~1-2 minutes
- **Files Transferred**: ~50-100 files
- **Transfer Size**: ~5-10MB

## 🛡️ Security Features

- ✅ Secure SSH key authentication
- ✅ Production-specific configuration files
- ✅ Proper file permissions
- ✅ Security headers in `.htaccess`
- ✅ Database credential protection

## 🔍 Troubleshooting

### Common Issues

1. **SSH Connection Failed**
   - Check server IP and credentials
   - Verify SSH key permissions

2. **Permission Denied**
   - Ensure `www-data` user has proper permissions
   - Check file ownership

3. **Site Not Accessible**
   - Verify `.htaccess` configuration
   - Check WordPress configuration
   - Clear caches

### Debug Mode

Run with debug output:

```bash
set -x
./deploy-advanced.sh
```

## 📝 Best Practices

1. **Always Test Locally**: Test changes locally before deploying
2. **Use Staging**: Deploy to staging environment first
3. **Monitor Deployments**: Check deployment logs and site functionality
4. **Regular Backups**: Keep regular backups of your site
5. **Update Dependencies**: Keep WordPress and plugins updated on the server

## 🆘 Support

For issues or questions:

1. Check the deployment logs
2. Verify server connectivity
3. Review configuration files
4. Check GitHub Actions logs for automated deployments

---

**Note**: This deployment system is optimized for WordPress sites with minimal file changes. For major WordPress updates, consider updating the core files directly on the server.
