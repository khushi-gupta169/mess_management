# Apache/XAMPP Setup Guide for CodeIgniter 4

## Option 1: Use PHP Development Server (Easiest)

The project is already running on:
```
http://localhost:8081
```

This is the simplest option for development and is already configured and working.

---

## Option 2: Set Up Apache/XAMPP

If you want to use Apache on port 8080, follow these steps:

### Step 1: Configure Apache Virtual Host

1. Open your Apache configuration file:
   - **XAMPP:** `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
   - **Laragon:** Usually auto-configured

2. Add this virtual host configuration:

```apache
<VirtualHost *:8080>
    DocumentRoot "E:/projects/newproject/public"
    ServerName hostelmess.local
    
    <Directory "E:/projects/newproject/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Step 2: Update Windows Hosts File (Optional)

If you want to use a custom domain like `hostelmess.local`:

1. Open Notepad as Administrator
2. Open file: `C:\Windows\System32\drivers\etc\hosts`
3. Add this line:
```
127.0.0.1 hostelmess.local
```

### Step 3: Ensure mod_rewrite is Enabled

In your Apache config (`httpd.conf`), make sure this line is uncommented:
```
LoadModule rewrite_module modules/mod_rewrite.so
```

### Step 4: Restart Apache

Restart Apache from XAMPP Control Panel or command line.

### Step 5: Access Your Application

- **With virtual host:** http://hostelmess.local:8080
- **Without virtual host:** http://localhost:8080

---

## Current Recommended Setup

For development, use the PHP built-in server:

```bash
php spark serve
```

Access at: **http://localhost:8081**

**Why?**
- No Apache configuration needed
- Easy to start/stop
- Perfect for development
- Already working!

---

## Production Deployment

For production, you should use Apache/Nginx with proper configuration pointing to the `public` folder as the document root.

### Important Security Notes for Production:

1. **Document Root:** Must point to `/public` folder only
2. **Environment:** Set to `production` in `.env`
3. **Debug Mode:** Disable in production
4. **Database:** Use production credentials
5. **HTTPS:** Enable SSL certificate
6. **File Permissions:** Restrict write permissions

---

## Troubleshooting

### "Not Found" Error on Apache
- Ensure DocumentRoot points to the `public` folder (not root)
- Check if mod_rewrite is enabled
- Verify .htaccess file exists in `public` folder

### Routes Not Working
- Enable mod_rewrite module in Apache
- Check AllowOverride is set to "All"
- Verify .htaccess is being read

### 403 Forbidden Error
- Check folder permissions
- Verify Apache has access to the project directory
- Check "Require all granted" in virtual host config