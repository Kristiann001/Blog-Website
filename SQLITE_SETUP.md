# SQLite Database Setup and Access

The application is configured to use SQLite for development and production.

## Database Location
The database file is located at:
`/home/kristiannkoome/Codes/Blog/database/database.sqlite`

## How to Access the Database

### 1. Using Artisan (CLI)
You can interact with the database using Laravel's Artisan Tinker:
```bash
php artisan tinker
```

### 2. Using SQLite CLI
If you have `sqlite3` installed on your system, you can access the database directly:
```bash
sqlite3 database/database.sqlite
```
Common commands:
- `.tables` - List all tables
- `.schema <table_name>` - Show schema for a specific table
- `SELECT * FROM users;` - Query data

### 3. Using GUI Tools
You can use various GUI tools to manage the SQLite database:
- **DB Browser for SQLite**: A high-quality, visual, open-source tool.
- **TablePlus**: A modern, native, and friendly tool for relational databases.
- **VS Code SQLite Extension**: Search for "SQLite" in VS Code marketplace to browse databases directly inside your editor.

## Configuration
The configuration is managed in the `.env` file:
```env
DB_CONNECTION=sqlite
# DB_DATABASE is automatically set to database_path('database.sqlite') in config/database.php
```

To run migrations:
```bash
php artisan migrate
```
