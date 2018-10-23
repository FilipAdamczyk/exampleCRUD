**Installation**
1) Download latest Koseven Framework from GitHub `https://github.com/koseven/koseven`.
2) Extract Koseven into a public directory of a web server(Apache, Nginx, IIS, etc...) `ex. /var/www/html`.
3) Point your web server to `public` directory.
4) Copy contents of this archive into the same directory as Koseven `ex. /var/www/html`.
5) REMOVE `install.php` file from `public` directory.
6) Create required database tables using `install.sql` from this archive.
    NOTE: If you don't have a DB user created, make sure to uncomment
    `CREATE USER` and `GRANT ALL PRIVILEGES` queries before running the SQL file.
7) Update DB config in `application/config/database.php` file.
8) Update trusted host in `application/config/url.php` to match your domain.
9) Run `npm install` inside `public` directory.
10) Navigate to `/users` of your domain `ex. http://localhost/users`.