Setup and quick notes

1) Create the database and tables (MySQL). Example schema:

```sql
CREATE DATABASE hotel_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hotel_management;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  fullname VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE userlog (
  id INT AUTO_INCREMENT PRIMARY KEY,
  uid INT NULL,
  username VARCHAR(255),
  userip VARCHAR(45),
  status TINYINT(1) NOT NULL,
  logtime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

2) Create an initial user. Use PHP to generate a password hash, then insert into `users`:

```php
<?php
echo password_hash('YourPasswordHere', PASSWORD_DEFAULT);
```

Then insert the returned hash into the `users` table:

```sql
INSERT INTO users (email, password, fullname) VALUES ('admin@example.com', 'PASTE_HASH_HERE', 'Admin');
```

3) Update DB credentials in `include/config.php`.

4) Place the project in your XAMPP `htdocs` (already in `c:/XAMPP/htdocs/proj/project1`).

5) Visit `http://localhost/proj/project1/user-login.php` to open the login page.

Security notes:
- Passwords use `password_hash()` / `password_verify()`.
- Prepared statements prevent SQL injection.
- Extend with HTTPS, rate-limiting, and CSRF protections for production.
