# 🏦 SmartBank Banking System

A comprehensive, full-stack banking system built with PHP 8.5, MySQL, Tailwind CSS v4, and JavaScript. Designed for modern banking operations with security, scalability, and user experience in mind.

## ✨ Features

- 🔐 **Secure Authentication** - Argon2id password hashing with JWT-like session management
- 🏦 **Multi-Account Banking** - Support for savings, checking, and investment accounts
- 💰 **Double-Entry Accounting** - Accurate financial record-keeping and reconciliation
- 📊 **Real-Time Processing** - Instant transaction processing and balance updates
- 👥 **Role-Based Access Control** - Admin, Teller, and Customer roles with granular permissions
- 📱 **Responsive Design** - Mobile-first UI with Tailwind CSS for seamless cross-device experience
- 📈 **Audit Trails** - Comprehensive logging for compliance and security monitoring
- 🌐 **RESTful API** - Clean API endpoints for integrations and mobile apps
- 🛡️ **Security Features** - CSRF protection, input validation, and secure session handling

## 🛠️ Technology Stack

- **Backend:** PHP 8.5 with MVC Architecture
- **Database:** MySQL 8.0+ via PDO with prepared statements
- **Frontend:** HTML5, Tailwind CSS v4, Vanilla JavaScript
- **Security:** Argon2id hashing, JWT-like tokens, CSRF protection
- **Build Tools:** Composer, npm, Tailwind CSS CLI
- **Architecture:** Model-View-Controller (MVC) pattern

## 📋 Prerequisites

Before installing, ensure you have the following:

- **PHP 8.5** or higher with CLI support
- **MySQL 8.0+** database server
- **Composer** for PHP dependency management
- **Node.js** and **npm** for frontend build tools
- **Git** for version control
- **Web Server** (Apache/Nginx) with PHP support

## 🚀 Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/sisovin/smart-bank-system.git
cd smart-bank-system
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
```

### 4. Database Setup

1. Create a new MySQL database
2. Import the database schema:

```bash
mysql -u your_username -p your_database_name < database.sql
```

3. Configure database connection in `config/database.php`

### 5. Environment Configuration

1. Copy `.env.example` to `.env`
2. Update the following variables:

```env
DB_HOST=localhost
DB_NAME=your_database_name
DB_USER=your_username
DB_PASS=your_password
APP_KEY=your_secret_key
APP_URL=http://localhost:8000
```

### 6. Build Assets

#### Development Build
```bash
npm run build-dev
```

#### Production Build
```bash
npm run build-prod
```

#### Watch Mode (Development)
```bash
npm run dev
```

### 7. Web Server Configuration

#### Using PHP Built-in Server (Development)
```bash
php -S localhost:8000 -t public/
```

#### Apache/Nginx Configuration

Ensure your web server points to the `public/` directory as the document root.

**Apache (.htaccess):**
```apache
RewriteEngine On
RewriteRule ^(.*)$ public/$1 [L]
```

**Nginx:**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/smart-bank-system/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

## 🎯 Usage

### Accessing the Application

1. **Public Landing Page:** `http://localhost:8000`
2. **Customer Login:** Navigate to login page from landing page
3. **Admin Panel:** Access via admin routes (role-based)

### Default Credentials

- **Admin User:** admin@smartbank.com / admin123
- **Test Customer:** customer@smartbank.com / customer123

### Key Endpoints

- `/` - Public landing page
- `/login` - User authentication
- `/dashboard` - User dashboard
- `/admin` - Admin panel
- `/api/*` - RESTful API endpoints

## 🏗️ Project Structure

```
smart-bank-system/
├── 📁 app/
│   ├── 📁 controllers/     # Business logic controllers
│   ├── 📁 models/         # Database models
│   └── 📁 middleware/     # Authentication & authorization
├── 📁 config/             # Configuration files
├── 📁 public/             # Web accessible files
│   ├── 📁 assets/         # CSS, JS, images
│   └── index.php          # Entry point
├── 📁 resources/          # Views and templates
│   ├── 📁 views/          # HTML templates
│   └── 📁 templates/      # Reusable components
├── 📁 tests/              # Unit and integration tests
├── 📁 vendor/             # Composer dependencies
├── composer.json          # PHP dependencies
├── package.json           # Node.js dependencies
├── database.sql           # Database schema
└── README.md             # This file
```

## 🧪 Testing

Run the test suite:

```bash
# PHP Unit Tests
composer test

# Or run specific test files
php vendor/bin/phpunit tests/
```

## 🚀 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Enable HTTPS/SSL certificates
- [ ] Configure proper file permissions
- [ ] Set up database backups
- [ ] Enable web server caching
- [ ] Configure monitoring and logging
- [ ] Update `APP_URL` to production domain

### Build Commands

```bash
# Production asset build
npm run build-prod

# Clear caches (if implemented)
php artisan cache:clear
```

## 🔒 Security

This application implements multiple security layers:

- **Password Security:** Argon2id hashing algorithm
- **Session Management:** Secure JWT-like tokens with rotation
- **Input Validation:** Server-side validation for all inputs
- **CSRF Protection:** Tokens for state-changing operations
- **SQL Injection Prevention:** PDO prepared statements
- **XSS Protection:** Output escaping and Content Security Policy

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

For support and questions:

- 📧 Email: support@smartbank.com
- 📖 Documentation: [Wiki](https://github.com/sisovin/smartbank-system/wiki)
- 🐛 Issues: [GitHub Issues](https://github.com/sisovin/smartbank-system/issues)

## 🙏 Acknowledgments

- PHP Community for robust backend framework
- Tailwind CSS for modern styling utilities
- MySQL for reliable database management
- Open source contributors

---

**Built with ❤️ for secure and efficient banking operations**