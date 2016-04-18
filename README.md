YКонтроллеры

/controllers/AlbumsController.php /controllers/UsersController.php

Модели

/models/Albums.php /models/Users.php

Настройка URL

/config/web.php

Что выполняет

GET http://localhost//web/index.php/albums GET http://localhost//web/index.php/users

получение постранично списка всех пользователей

если

GET http://localhost//web/index.php/users?name='имя'&role='роль'

вывод будет отфильтрован по указанным значения полей модели работает для Users, Albums

HEAD http://localhost//web/index.php/albums HEAD http://localhost//web/index.php/users

получение метаданных листинга пользователей

POST http://localhost//web/index.php/albums POST http://localhost//web/index.php/users

создание нового пользователя, альбома в теле пост данные для таблицы в формате имяполя:значение, имяполя&значение

GET http://localhost//web/index.php/albums/id_альбома GET http://localhost//web/index.php/users/id_пользователя

получение данных указанного в id пользователя, альбома

HEAD http://localhost//web/index.php/albums/id_альбома HEAD http://localhost//web/index.php/users/id_пользователя

получение метаданных указанного в id пользователя, альбома

PUT http://localhost//web/index.php/albums/id_альбома PUT http://localhost//web/index.php/users/id_пользователя

изменение данных пользователя, альбома указанного в id

DELETE http://localhost//web/index.php/albums/id_альбома DELETE http://localhost//web/index.php/users/id_пользователя

удаление данных пользователя, альбома указанного в id

OPTIONS http://localhost//web/index.php/albums OPTIONS http://localhost//web/index.php/users

получить методы, по которым можно обратиться к users, albums

OPTIONS http://localhost//web/index.php/albums/id_альбома OPTIONS http://localhost//web/index.php/users/id_пользователя

получить методы, по которым можно обратиться к указанной в id записи users, albums

Статусы ответа:

200 - успешное выполнение GET, PUT, HEAD, OPTIONS

201 - успешное выполнение POST

204 - успешное выполнение DELETE

404 - объект не найден

401 - требуется авторизация

403 - доступ запрещен

405 - метод не разрешен

Уже умеем:
проверять разрешения на действия по ролям через ACF фильтры и RBAC,
а также настроено правило is Owner для обеих версий контроля авторизации, которое проверяет - является ли пользователем автором записи

Также убрали дублирующий код контроллеров в MainController

еще не все
продолжение следует

~~~
