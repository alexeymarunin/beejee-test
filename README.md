# Инициализация проекта

* Скопировать файл `.env.example` в `.env`. Если необходимо - изменить нужные переменные в нем.
* Создать пустой файл `db.sqlite3` в папке `data`. Если он уже существует, то пересоздать
* Выполнить команду `php install.php`. Будет проведена проверка наличия необходимых компонентов,
а также инициализирована БД

# Запуск Docker

* Выполнить инициализацию проекта
* Перейти в каталог `docker`
* Выполнить команду `docker-compose up --build`

&copy;2020 Марунин Алексей
