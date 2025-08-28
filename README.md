# Laravel Todo App - Installation Guide

A Todo List application built with Laravel 12, Livewire 3, and Bootstrap 5.

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- **PHP 8.3 or higher** with required extensions
- **Composer** (PHP dependency manager)
- **Node.js** and **NPM** (for asset compilation)
- **SQLite** (database)
- **Git** (version control)



## Installation Steps

### 1. Clone the Repository

```bash
# Clone the repository
git clone https://github.com/Renelle-git/laravel-livewire-todo-exam.git

# Navigate to project directory
cd laravel-livewire-todo-exam
```

### 2. Install PHP Dependencies

```bash
# Install Composer dependencies
composer install

# If you encounter memory issues:
composer install --no-dev --optimize-autoloader
```

### 3. Environment Configuration

# Generate application key
```
php artisan key:generate
```

### 4. Configure Database

Edit the `.env` file with your database credentials:

```env
# Database Configuration
DB_CONNECTION=sqlite


# Application Settings
APP_NAME="Laravel Todo App"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

### 5. Run Database Migrations

```bash
# Run migrations to create tables
php artisan migrate

# Optional: Seed with sample data
php artisan db:seed
```

### 6. Install Node Dependencies & Build Assets

```bash
# Install Node.js dependencies
npm install

# Build assets for development
npm run dev

# OR build for production
npm run build
```

### 7. Start the Development Server

```bash
# Start Laravel development server
php artisan serve

# Server will start at: http://127.0.0.1:8000
```

## Project Structure

```
laravel-todo-app/
├── app/
│   ├── Livewire/
│   │   └── TodoList.php          # Main Livewire component
│   └── Models/
│       └── Todo.php              # Todo model
├── database/
│   └── migrations/
│       └── create_todos_table.php # Database schema
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php     # Main layout
│       ├── livewire/
│       │   └── todo-list.blade.php # Todo component view
│       └── todos.blade.php       # Main page
├── routes/
│   └── web.php                   # Web routes
├── .env.example                  # Environment template
└── composer.json                 # PHP dependencies
```


## Troubleshooting

### Common Issues

**1. Assets Not Loading**
```bash
# Rebuild assets
npm run dev
# or
npm run build
```
***If the issues persistent or the page is not displaying anything or updating***
    -Try to refresh the page


**2. Livewire Not Working**
```bash
# Clear all caches
php artisan optimize:clear

```
## Additional Resources
- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com)
- [Bootstrap 5 Documentation](https://getbootstrap.com)
- [Font Awesome Icons](https://fontawesome.com)
