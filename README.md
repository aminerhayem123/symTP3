# Symfony TPs

This project is a web application using symfony. It's my work for TP(s) [Academic Project].

### `TPs List`

- ✔️ [TP01](TP01.pdf)
- ✔️ [TP02](TP02.pdf)
- ✔️ [TP03](TP03.pdf)

### `Setup prerequists`

- You have to install [php](https://www.php.net/downloads.php).
- You have to install [composer](https://getcomposer.org/).
- You have to install sql database ([mysql](https://www.mysql.com/downloads/), [postgresql](https://www.postgresql.org/download/), ...etc).

### `How to run the porject`

- Clone or download this repo.
- Open terminal and go to project path.
- Write this command `php composer.json install` to install dependencies.
- Run the sql server and create a database.
- Go to `.env` file and add your custom `DATABASE_URL`.
- Run the migration through these commands;

  ```bash
  php bin/console make:migration
  php bin/console doctrine:migrations:migrate
  ```

- Run the porject by these command `php -S 127.0.0.1:8000 -t public`.

#### Note: the internet needed for use bootstrap and sweetalert beaucase of the CDNs.

### `License`

[MIT](LICENSE) &copy; [Imed Jaberi](https://github.com/3imed-jaberi)
