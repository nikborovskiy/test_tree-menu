# Разворачивание проекта
1. git clone https://github.com/nikborovskiy/test_tree-menu.git
2. Переходим в каталог app
3. composer install
4. Настроить файл конфигурации для БД app/config/db.php
5. Выполнить миграции - php app/yii migrate
6. Создать папку assets в app/web/ (если ее нет) и дать права для записи при необходимости.
7. Настроиить сервер (входящий скрипт в папке app/web/).
8. Приложение готово для использования. Переходим на http://your-domain
