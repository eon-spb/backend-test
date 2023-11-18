<h1 align="center">Тестовое задание для Backend разработчика</h1>
<p align="center"><a href="https://eon.estate" target="_blank"><img src="https://eon.estate/static/images/logoAndName.svg" width="200"></a></p>
<p align="center">
Добро пожаловать на тестирование для Backend разработчика.<br>Мы ценим ваше время и поэтому подготовили для вас небольшое задание.
</p>

### Задание
Создать команду, которая будет парсить xml файл `storage/tmp/test.xml` и сохранять элементы `apartments` в базу данных. 
<br>
Для создания файла с тестовыми данными использовать команду

```shell
php artisan test-xml:create
```
Сохранять записи нужно в бд в таблицу `apartments`, колонки в таблице необходимо назвать также как атрибуты `apartment`.

### Технические требования
1) Команда должна запускаться каждые 4 часа в единственном экземпляре
2) Команда должна потреблять не более 125 мб оперативной памяти
3) Команда должна выполняться не более 30 минут

### Оценка результатов
Оценка результатов будет производиться по следующим критериям:
1) Работоспособность приложения.
2) Качество кода и его читаемость.
3) Структура и организация приложения.
4) Покрытие тестами 

### Как приступить к выполнению задания
1) Сделайте fork тестового задания
2) Склонируйте репозиторий с тестовым заданием.
3) Создайте новую ветку.
4) Выполните задание.
5) Зафиксируйте изменения и отправьте их на GitHub, создайте pull-request.
6) Напишите нам, что вы выполнили задание.
Вопросы можно задавать в issue. 

### Запуск приложения 

### Необходимые инструменты:
1) Docker
<a href="https://www.docker.com/products/docker-desktop/" target="_blank">Устанавливаем докер</a>

2) go-migrate
``` shell 
 Mac
 
 brew install golang-migrate
 
 Windows
 
 В котрытом PowerShell вводим следующие команды 
 
 iwr -useb get.scoop.sh | iex
 
 scoop install migrate
``` 

3) Golang 
<a href="https://go.dev/doc/install" target="_blank">Устанавливаем Golang</a>



### Запуск

Клонируем проект, открываем консоль в корневой директории проекта и вводим слудующие команды 
```shell
docker compose -f docker-compose.dev.yml up (Данная команда запустит базу данных "postgresql")

Запускаем миграцию, для инициализации таблицы 

migrate -path internal/db/migrations  -database "postgres://postgres:postgres@localhost:5435/backend_Interview?sslmode=disable" up

Далее запускаем файл проекта, который будет запускаться каждую минуту (для тестирования) 
./build/application 

Данная команда позволит зайти в контейнер и самостоятельно убедиться в наличии данных в безе
Запускаем команду в терминале и выполняем команду Select * from Apartments;
docker compose -f docker-compose.dev.yml exec db psql -U postgres -d backend_Interview 


Чтобы запустить процесс в фоновом режиме, использовать команду `nohup  ./build/application &` для поиска процесса `pgrep application`. 
Чтобы убить процесс, использовать команду `pgrep application` и `kill PID` из pggrep 
Чтобы убить процесс на Windows, необходимо вызвать команду `tasklist` и с помощью CTRL + F найти процесс с именем application.exe
После чего вызвать команду `taskkill /F /PID 1234`

``` 