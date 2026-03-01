En:

Installation of payment system and token changes
Import database sql.sql
In the system file base.php, change the database credentials
Attach pay.php file via HTTP GET query

Example: https://test.com/pay.php?amount=100&user=1&url=test.ru&desc=payDescription

Explanation of parameters in this link:
amount - payment amount
user - user ID from contacts list
url - user redirect page after payment (!write url without http)
desc - Description/Purpose/Name of payment

Script file structure:

pay.php - Index pay script
base.php - connection base data
listpay.php - test file list transaction
redirect.php - file redirect url success pay
chekpay.php - file webhook + api platform
reg.php - add file registration

Ru:

Установка платежной системы и изменение токенов
Заливаем базу данных sql.sql
В системном файле base.php меняем данные от БД
Подключаем файл pay.php через HTTP GET запрос

Пример: https://test.ru/pay.php?amount=100&user=1&url=test.ru&desc=payDescription

Разъяснение параметров в данной ссылке:
amount - сумма платежа
user - id пользователя из списка контактов
url - страница перенаправления пользователей после платежа (!url пишем без http)
desc - Описание/Назначение/Название платежа

Файловая структура скрипта:

pay.php - Главный скрипт платежа
base.php - подключение базы данных
listpay.php - тестовый файл со списком транзакций
redirect.php - файл перенаправления при успешном платеже
chekpay.php - файл вебхука + API платформы
reg.php - файл регистрации
