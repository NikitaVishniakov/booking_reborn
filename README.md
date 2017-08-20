Система управления отелем %system_name% 
=====================

Структура 
-----------------------------------

Исплользуется система роутинга. Роутинг настроен через класс Router.php. Находится в core/
Через .htaccess все запросы к серверу перенаправляются к index.php, где запрос опбрабатывается Router
и, вызывается соответсвующий контроллер с соответствующим методом.

### core/ 
ядро проекта. Там расположенны базовые классы в директории core/base

funcs.php - набор функций используемых в проекте. Часть из них ненужная, но еще не реффакторил. Я сначала наговнокодил,
а потом уже взялся перепиливать ядро. В связи с нехваткой времени часть костыльного и старого функционала пришлось оставить
каким он был и просто интегрировать в новую версию, отложив рефакторинг на потом.

### models/ 
Тут у нас недомодели. Есть базовый класс core/base/Model.php - по сути это квери-билдер. Для каждой сущности создаю свою "модель",
чтобы а) была возможность расширить функционал базовой модели, б) чтобы повысить читаемость кода:)

### controllers/ 
Тут контроллеры. 
Сейчас, как мне кажется используются несовсем по назначению. Функциональые блоки там пишу только когда использую ajax.

### public/ 

Отдельная вьюха для лендинга. Со своими стилями и структурой

### templates

Шаблоны. Вызываются в view

### views 
Виды соответсвующих контроллеров.
Контроллер автоматически вывывает вид, если он есть.
Виды для каждого контроллера должны лежать в директории с соответсвующим названием. Название самого файла вида должно
соответствовать названию вызвавшего его метода. Темплейты в видах подключаются руками, для указания путей есть специальная константа
TEMPLATES. Указываем в виде require_once TEMPLATES . "ИМЯ_ШАБЛОНА.PHP".





Cистема управления отелем отображает разнесенные на номерам и датам брони, позволяет вносить новые, редактировать существующие брони. В системе реализована ролевая модель, в соответствии с которой можно ограничивать доступ к разделам портала или запрещать ряд действий. Реализован механизм защиты от внесения бронирования поверх существующих броней.

В рамках системы реализован механизм передачи кассовых смен и автоматическое выписывание счетов постояльцам. Логика системы такова, что администраторы отелей не имеют возможности красть деньги или ошибаться в расчетах. 

В рамках системы будет также реализован конструктор лендингов, сейчас имеется просто статичный лендинг с небольшой динамикой( можно редактировать цены и описания).
На лэндинге реализован самописный джс-слайдер, который учитывает размер устройства и позволяет не загружать лишние изображения, что требуется для большинства других плагинов-слайдеров.

Инсталяцион
-----------------------------------
1. Стягиваем репозиторий к себе.
2. в папке 
    dir /core
   Создаем файл **config.php**.
   
   Со следующим содержимым:
```php
<?php
//Настройки базы. Собственно из за этого и весь сырбор.
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'username'); // Имя пользователя базы
define('DB_PASSWORD', 'password'); // Пароль
define('DB_DATABASE', 'database'); //Имя бд

// PATHS
define('COMPONENTS_PATH', $_SERVER['DOCUMENT_ROOT'].'/controllers/');
define('MODAL_PATH', $_SERVER['DOCUMENT_ROOT'].'/modals/');
define('CORE', $_SERVER['DOCUMENT_ROOT'].'/core/');
define('TEMPLATES', $_SERVER['DOCUMENT_ROOT'].'/templates/');
define('WWW', __DIR__);
define('ROOT', dirname(__DIR__));
define('VIEWS', $_SERVER['DOCUMENT_ROOT'] . '/views/');
define('HEADER_OLD', $_SERVER['DOCUMENT_ROOT'].'/header_old.php');
define('PUBLIC_PATH', $_SERVER['DOCUMENT_ROOT'].'/public/');
define('HEADER', $_SERVER['DOCUMENT_ROOT'].'/header.php');
define('FOOTER', $_SERVER['DOCUMENT_ROOT'].'/footer.php');


define('LAYOUT', 'default');

?>
```
3. Далее необходимо создать таблицы в базе. Пока что, к сожалению еще не сделал механизм миграций, так что все сурово.
Берем файл: **make_me_db_plz.sql**
И импортируем его в свою бд.



Коротко о функционале:
-----------------------------------

Cистема управления отелем отображает разнесенные на номерам и датам брони, позволяет вносить новые, редактировать существующие брони. В системе реализована ролевая модель, в соответствии с которой можно ограничивать доступ к разделам портала или запрещать ряд действий. Реализован механизм защиты от внесения бронирования поверх существующих броней.
В рамках системы реализован механизм передачи кассовых смен и автоматическое выписывание счетов постояльцам. Логика системы такова, что администраторы отелей не имеют возможности красть деньги или ошибаться в расчетах. 
В рамках системы будет также реализован конструктор лендингов, сейчас имеется просто статичный лендинг с небольшой динамикой( можно редактировать цены и описания).
На лэндинге реализован самописный джс-слайдер, который учитывает размер устройства и позволяет не загружать лишние изображения, что требуется для большинства других плагинов-слайдеров.


**/booking_table** Сводная таблица бронирований за определенный промежуток времени. Вверху страницы имеется дайджест событий на сегодня(заезды, выезды, кто проживает, у кого нужно списать предоплату. Также в этом дайджесте выводится напоминание о том, что человек брал ключ под залог. При заезде, администратор отмечает заезд гостя. При отметке заезда, выскакивает модальное окно, где указана сумма к оплате. Администратор выбирает способ оплаты и подтверждает оплату. Также администратор может изменить сумму, которую оплатил гость, и тогда у человека будет отображаться задолженность все время его проживания до тех пор, пока он не оплатит задолженность.)
В самой таблице при помощи иконок отображается информация о бронях - имя, статус гостя, количество персон, наличие завтраков и прочее. При помощи цветовой гаммы также отображаются различные статусы бронирований. Бронь можно внести кликнув по таблице на пересечени нужной даты и нужного номера. Значения автоматически подставятся в форму добавления бронирования. При добавлении брони, итоговая сумма высчитывается авотматически на основе занесенных в систему тарифов на  определенные даты. Данные цены можно изменить, применить к ним скидку.

**/booking_page/$id** - вывод информации о каждом конкретном бронировании, с возможностью редактирования данных бронирования, внесеня оплат, отображнеия задолженности, добавления услуг, почасового продления.
Управляющий имеет возможность настраивать количество услуг, их стоимость и себестоимость для дальнейшего учета.
Имеется возможность настройки размера, длительности и возможности почасового продления.

**/cashdesk** - Касса. Отображается 3 последних смены, можно вывести сколько угодно смен. Можно внести изменения в любую из смен и баланс во всех последующих сменах будет пересчитан в соответствии с изменением. Вносить изменения может только администратор системы. (администратор системы != администратор отеля)
В начало каждой смены автоматически перекидывается остаток денег в кассе с предыдущей смены, чтобы администраторы могли сдавать и принимать кассу без закрытия и открытия смены. 
Смена автоматически переключается в 11 часов утра. 
Под каждой сменой выводится краткий отчет о количестве нала, безнала и общем итоге смены.

**/incomes** - расчет прибыли отеля. Доходы и часть издержек(эквайринг, комиссия агрегаторов, возвраты) высчитываются автоматически. Доходы считаются на основе поступающих платежей, размер которых всегда формируется системой, поэтому исключены возможности ошибок в расчетах.

**/costs** Управляющий отелем имеет возможность создавать и редактировать свои категории расходов и вести их учет.

В системе имеется еще множество другого функционала, в документе описан самый основной- то, на чем основывается система.
