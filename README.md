# Create your first blog in PHP

Project number five completed as part of my OpenClassrooms training.

### Requirements

 * Apache 2.4
 * PHP 8.1
 * MySQL 8.0
 * Composer 2.3
 * Node.js 18.4

## Install

1. In your terminal, execute the following command to clone the project into the "blog" directory.
```shell
git clone https://github.com/damien-jandard/create-your-first-blog-in-PHP.git blog
```

2. Access the "blog" directory using the following command.
```shell
cd blog
```

3. Install the composer dependencies using the following command.
```shell
composer install
```
4. Import the .sql file located at the root of the project into your database management system.
You can use the following command to do that.
```sql
mysql -u root -p blog<blog.sql
```
Please make sure to modify the username, password, and database name if necessary.

5. Modify line 13 of the Manager.php file if your credentials differ from the default ones (the file is located in /models/managers/).
```php
$this->pdo = new  PDO('mysql:host=127.0.0.1;dbname=blog;charset=utf8', 'root', '');
```

6. You can test the website using the following credentials.

- Administrator Account:
	- Username: admin@blog.com
	- Password: Admin1234*

- User Account:
	- Username: user@blog.com
	- Password: User1234*

7. To enable local email sending, you can install [MailHog](https://github.com/mailhog/MailHog).