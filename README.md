# MikroTik RADIUS Management Application

This is a Laravel-based web application for managing MikroTik RADIUS authentication and accounting. The application provides a web interface to manage NAS (Network Access Server) devices and RADIUS user authentication.

## Features

- **NAS Management**: Manage Network Access Server devices with details like IP addresses, secrets, and descriptions
- **RADIUS User Management**: Handle user authentication through RADIUS protocol
- **User Groups**: Manage user groups and their permissions
- **Modern UI**: Clean and responsive web interface using Bootstrap/Tailwind CSS

## Database Schema

The application uses the following main tables:
- `nas` - Network Access Server devices
- `radcheck` - User authentication checks
- `radreply` - User authentication replies
- `radusergroup` - User group assignments
- `radgroupcheck` - Group-based authentication checks
- `radgroupreply` - Group-based authentication replies
- `radacct` - RADIUS accounting records
- `radpostauth` - Post-authentication logging

## Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- SQLite (default) or MySQL/PostgreSQL

### Installation Steps

1. **Install PHP dependencies**
   ```bash
   composer install
   ```

2. **Install Node.js dependencies**
   ```bash
   npm install
   ```

3. **Environment setup**
   ```bash
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan storage:link
   ```

5. **Build frontend assets**
   ```bash
   npm run build
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

The application will be available at `http://127.0.0.1:8000`

## Usage

### Accessing the Application
- **Home Page**: `http://127.0.0.1:8000/` - Welcome page
- **NAS Management**: `http://127.0.0.1:8000/nas` - View and manage NAS devices

## Development

### Running in Development Mode
```bash
# Start the Laravel server
php artisan serve

# In another terminal, start the frontend development server
npm run dev
```

### Optimization for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## Troubleshooting

### Common Issues

1. **Storage Link Error**: Run `php artisan storage:link`
2. **Permission Issues**: Ensure `storage/` and `bootstrap/cache/` are writable
3. **Database Issues**: Check your `.env` file database configuration
4. **Asset Issues**: Run `npm run build` to compile frontend assets

### Clearing Caches
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
