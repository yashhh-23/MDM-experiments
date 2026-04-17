# PHP MySQL CRUD (XAMPP)

This project provides a secure CRUD webpage using PHP + MySQL with:
- Create, Read, Update, Delete for users
- Input validation and output escaping
- PDO prepared statements (SQL injection protection)
- Session-based flash messages
- CSRF token validation
- Cookie support (stores the last saved email)

## Files
- `index.php` : main UI and CRUD handlers
- `db.php` : PDO database connection
- `config.php` : database credentials
- `functions.php` : security and validation helpers
- `schema.sql` : database and table creation SQL

## Setup with XAMPP
1. Start **Apache** and **MySQL** in XAMPP Control Panel.
2. Import `schema.sql` using phpMyAdmin:
   - Open `http://localhost/phpmyadmin`
   - Create/import SQL from `schema.sql`
3. Place this folder under your web root (for example `htdocs/Experiment6`) or map it via virtual host.
4. Confirm database settings in `config.php`:
   - host: `127.0.0.1`
   - port: `3306`
   - db: `user_management`
   - user: `root`
   - password: `` (empty by default in many XAMPP installs)
5. Open in browser:
   - `http://localhost/Experiment6/index.php`

## Security Notes
- Never trust client-side validation alone; server validation is implemented.
- Use prepared statements (implemented with PDO).
- Use HTTPS in production for secure cookies.
- Change default MySQL credentials before production deployment.
