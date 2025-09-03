# GenealogyDocuments.org

A WordPress website for genealogy document management and three-dimensional scans.

## 🌐 Live Site
- **Production:** https://gendocs.org/
- **Admin:** https://gendocs.org/wp-admin/

## 🚀 Deployment

This project uses GitHub Actions for automated deployment to Digital Ocean.

### Automatic Deployment
- Push to `main` branch triggers automatic deployment
- Manual deployment can be triggered from GitHub Actions tab

### Manual Deployment
```bash
./deploy.sh
```

## 🛠️ Local Development

### Prerequisites
- XAMPP (Apache, MySQL, PHP)
- Git

### Setup
1. Clone the repository
2. Copy `wp-config-production.php` to `wp-config.php`
3. Update database credentials in `wp-config.php`
4. Import the database dump
5. Start XAMPP services

### Database
- **Local:** `genealogydocuments` (MySQL via XAMPP)
- **Production:** Digital Ocean Managed MySQL

## 📁 Project Structure

```
├── .github/workflows/     # GitHub Actions
├── wp-content/           # WordPress content
├── wp-admin/            # WordPress admin
├── wp-includes/         # WordPress core
├── deploy.sh            # Deployment script
├── wp-config-production.php  # Production config
└── README.md            # This file
```

## 🔐 Security

- SSL certificates via Let's Encrypt
- Automatic HTTPS redirects
- Secure file permissions
- Database credentials in environment variables

## 📝 Admin Access

- **Username:** devroot
- **Password:** [Contact administrator]

## 🔄 Backup

Automatic backups are created before each deployment and stored in `/var/backups/wordpress/` on the server.

## 📞 Support

For issues or questions, please contact the site administrator.

## 🧪 Test Deployment

Testing automated deployment system - commit timestamp: $(date)
