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
Вопросы можно задавать в issue. Удачи!
