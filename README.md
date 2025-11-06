# Internship System

Project skeleton built with Laravel 12 (PHP 8.2+) and Vite. This guide explains how to clone, configure, and run the app locally after pushing/cloning from GitHub.

## Prerequisites
- PHP 8.2 or newer (with extensions: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Fileinfo)
- Composer 2.x
- Node.js 18+ and npm (for Vite / frontend assets)
- A database server (MySQL 8+ or MariaDB 10.6+ recommended). SQLite is also possible.

Optional, nice-to-have:
- Git
- Redis (not required; queues default to database)
- Docker (if you want to use Laravel Sail)

## Quick Start (Windows/macOS/Linux)

1) Clone the repository
- git clone https://github.com/your-org/internship_system.git
- cd internship_system

2) Create your environment file
- Copy .env.example to .env
- On Windows (PowerShell): copy .env.example .env
- On macOS/Linux: cp .env.example .env

3) Configure .env
- Set APP_NAME, APP_URL as you prefer (default http://localhost)
- Database (MySQL example):
  - DB_CONNECTION=mysql
  - DB_HOST=127.0.0.1
  - DB_PORT=3306
  - DB_DATABASE=internship_system
  - DB_USERNAME=root
  - DB_PASSWORD=your_password
- Alternatively, to use SQLite:
  - DB_CONNECTION=sqlite
  - Create a file database/database.sqlite (empty file)
  - Remove other DB_* lines or leave them unused
- Sessions, cache, and queue are configured to use the database. Migrations will create the necessary tables.

4) Install PHP dependencies
- composer install

5) Generate the application key
- php artisan key:generate

6) Run database migrations (and optionally seeders if you add them later)
- php artisan migrate

7) Install frontend dependencies
- npm install

8) Build assets (production) or run the dev server
- Production build: npm run build
- Development (hot reload): npm run dev

9) Start the application server
- php artisan serve
- Visit the URL printed in the console (typically http://127.0.0.1:8000)

## One-Command Setup (optional)
This project includes a Composer script that automates the most common steps. Make sure your .env database settings are correct and the database exists before running it.

- composer run setup

What it does:
- composer install
- Copies .env if missing
- php artisan key:generate
- php artisan migrate --force
- npm install
- npm run build

## Recommended Dev Workflow
- Start everything concurrently (server, queue worker, Vite) in one terminal using:
  - composer run dev
- What this does under the hood:
  - Runs php artisan serve
  - Runs php artisan queue:listen --tries=1 (queues use the database connection by default)
  - Runs npm run dev (Vite dev server)

If you prefer, run each command in its own terminal:
- php artisan serve
- php artisan queue:listen --tries=1
- npm run dev

## Testing
- Clear config cache and run tests:
  - composer test
- Or manually:
  - php artisan config:clear
  - php artisan test

## Common Troubleshooting
- SQLSTATE[HY000] [1049] Unknown database 'internship_system'
  - Create the database first, e.g. in MySQL: CREATE DATABASE internship_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  - Ensure DB_DATABASE in .env matches the created database.
- Access denied for user
  - Ensure DB_USERNAME/DB_PASSWORD are correct and the user has privileges: GRANT ALL ON internship_system.* TO 'user'@'localhost'; FLUSH PRIVILEGES;
- Port already in use (8000)
  - Run php artisan serve --port=8001 (and update APP_URL if needed)
- npm ERR!
  - Ensure Node 18+ is installed. Delete node_modules and package-lock.json, then run npm install again.
- Missing encryption key
  - Run php artisan key:generate (adds APP_KEY in .env)

## Using Docker (Laravel Sail) – optional
Sail is included as a dev dependency. If you prefer Docker, you can set it up:
- composer require laravel/sail --dev (already present in composer.json but ensure vendor is installed)
- php artisan sail:install (choose services you need)
- vendor/bin/sail up -d
- vendor/bin/sail artisan migrate
- vendor/bin/sail npm install && vendor/bin/sail npm run dev

Then access the app via the URL printed by Sail (typically http://localhost).

## Project Notes
- Framework: Laravel 12
- PHP: ^8.2
- Frontend tooling: Vite + Tailwind CSS + Alpine.js
- Queues: database driver by default (queue:listen)
- Sessions / Cache: database driver by default

## Scripts Reference
Composer (package manager for PHP):
- composer run setup — End-to-end install, migrate, and build
- composer run dev — Run server, queue worker, and Vite dev server concurrently
- composer test — Clear config cache and run tests

NPM (frontend):
- npm run dev — Vite development server
- npm run build — Production build

## License
This project is open-sourced software licensed under the MIT license.
