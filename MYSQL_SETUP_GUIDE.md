# MySQL Setup Guide for Hostel Mess Management System

## Current Issue
The application cannot connect to MySQL because:
1. MySQL server is not installed, OR
2. MySQL server is not running, OR
3. MySQL is installed but not accessible from command line

## Solution: Install and Start MySQL

### Option 1: Install XAMPP (Recommended for Windows)

1. **Download XAMPP**
   - Visit: https://www.apachefriends.org/download.html
   - Download the Windows version
   - Install it (default location: C:\xampp)

2. **Start MySQL**
   - Open XAMPP Control Panel
   - Click "Start" button next to MySQL
   - Wait until it shows "Running" in green

3. **Verify MySQL is Running**
   - MySQL should be running on port 3306
   - You should see "Apache" and "MySQL" both running in XAMPP

4. **Access phpMyAdmin** (Optional but helpful)
   - Start Apache in XAMPP (if not running)
   - Open browser: http://localhost/phpmyadmin
   - Verify `hostel_mess_db` database exists

### Option 2: Standalone MySQL Installation

1. **Download MySQL**
   - Visit: https://dev.mysql.com/downloads/installer/
   - Download MySQL Installer for Windows
   - Install MySQL Community Server

2. **Start MySQL Service**
   - Open Command Prompt as Administrator
   - Run: `net start mysql` or `net start mysql80` (version dependent)

### Option 3: Alternative - Use SQLite (No Server Required)

If you want to skip MySQL setup temporarily, we can use SQLite:

1. Update `.env` file:
```env
database.default.DBDriver = SQLite3
database.default.database = writable/database.db
```

2. Run migrations:
```bash
php spark migrate
```

## Current Database Configuration

The application is configured with:
- **Database Name**: hostel_mess_db
- **Username**: root
- **Password**: (empty)
- **Host**: localhost
- **Port**: 3306

## After MySQL is Running

Once MySQL is running, execute:

```bash
php spark migrate
```

This will create all the necessary tables:
- users
- students
- parents
- kyc_documents
- menus
- menu_items
- holidays
- extra_meals
- fee_records
- payments
- notifications

## Verify Database Connection

Test the connection:
```bash
php spark db:table users
```

## Need Help?

If you continue to face issues:
1. Check if MySQL service is running in Services (services.msc)
2. Verify port 3306 is not blocked by firewall
3. Check MySQL error logs
4. Try connecting via MySQL Workbench or phpMyAdmin

## Contact

If you need assistance with MySQL setup, please let me know which installation method you prefer.