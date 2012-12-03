<?php
/*
+ ----------------------------------------------------------------------------+
|     Russian Language Pack for e107 0.7
|     $Revision: 237 $
|     $Date: 2009-09-20 16:18:50 +0600 (Вс, 20 сен 2009) $
|     $Author: yarodin $
+----------------------------------------------------------------------------+
*/
define("LANINS_TITLE", "Установка e107");
define("LANINS_000", "Произошел сбой. Установка отменена");
define("LANINS_001", "Версия %1$s");
define("LANINS_002", "Установка");
define("LANINS_002a", "(Шаг %1$s из 7)");
define("LANINS_003", "1");
define("LANINS_004", "Выбор языка");
define("LANINS_004a", "Язык выбран");
define("LANINS_004b", "Язык");
define("LANINS_005", "Пожалуйста, выберите язык, на котором будет производиться установка");
define("LANINS_006", "Выбрать язык");
define("LANINS_007", "4");
define("LANINS_008", "Проверка версий PHP и MySQL; проверка разрешений файлов");
define("LANINS_008a", "Совместимость и разрешения файлов");
define("LANINS_009", "Перепроверить разрешения файлов");
define("LANINS_010", "Файл не перезаписываемый:");
define("LANINS_010a", "Каталог не перезаписываемый:");
define("LANINS_011", "Ошибка");
define("LANINS_012", "MySQL функции, похоже, отсутствуют. Это, вероятно, означает, что PHP-расширения MySQL не установлены, либо ваша установка PHP не была скомпилирована с поддержкой MySQL.");
define("LANINS_013", "Невозможно определить версию MySQL. Это не фатальная ошибка, поэтому, пожалуйста, продолжайте установку, но имейте в виду, что e107 требует MySQL >= 3.23, чтобы корректно функционировать.");
define("LANINS_014", "Разрешения файлов");
define("LANINS_015", "Версия PHP");
define("LANINS_016", "MySQL");
define("LANINS_017", "ПРОЙДЕНО");
define("LANINS_018", "Пожалуйста, убедитесь, что все перечисленные файлы существуют и на них открыты права на запись для сервера. Обычно это означает CHMOD = 777, но окружения различаются - проконсультируйтесь с хост-провайдером, если у вас есть какие-либо проблемы.");
define("LANINS_019", "Установлена версия PHP не совместима с e107. Необходима версия PHP 4.3.0 или выше. Либо сделайте апгрейд вашей версии PHP, либо обратитесь к хост-провайдеру, чтобы он сделал апгрейд.");
define("LANINS_020", "Продолжить установку");
define("LANINS_021", "2");
define("LANINS_022", "Информация о сервере MySQL");
define("LANINS_022a", "База данных");
define("LANINS_023", "Пожалуйста, введите настройки своей базы данных.<br /><br />Если вы обладаете правами root, Вы можете создать новую базу данных, отметив соответствующий чекбокс, если нет, Вы должны создать базу данных или использовать имеющуюся.<br /><br />Если у вас только одна база данных, используйте префикс так, чтобы другие скрипты могли совместно использовать ту же самую базу данных.<br />Если вам не известна информация о сервере MySQL, свяжитесь с вашим хост-провайдером.");
define("LANINS_024", "MySQL сервер:");
define("LANINS_025", "MySQL логин:");
define("LANINS_026", "MySQL пароль:");
define("LANINS_027", "MySQL База данных:");
define("LANINS_028", "Создать базу данных?");
define("LANINS_029", "Префикс имен таблиц:");
define("LANINS_030", "Сервер MySQL, предназначенный для использования системой e107. Он также может включать номер порта. Например: “hostname:port” или путь до локального сокета, например: \":/path/to/socket\" на локальном хосте.");
define("LANINS_031", "Имя пользователя, которое e107 будет использовать для соединения с вашим сервером MySQL");
define("LANINS_032", "Пароль, соответствующий имени пользователя, которое вы ввели");
define("LANINS_033", "База данных MySQL, в которой вы хотите, чтобы находилась e107, иногда называемая схемой. Если пользователь обладает правами создания базы данных, Вы можете создать новую базу данных, отметив соответствующий чекбокс.");
define("LANINS_034", "Префикс, который вы можете использовать для создания таблиц e107. Полезно, если у вас только одна база данных и нужно несколько установок e107 на одной базе данных.");
define("LANINS_035", "Продолжить");
define("LANINS_036", "3");
define("LANINS_037", "Проверка соединения с MySQL");
define("LANINS_038", " и создание БД");
define("LANINS_038a", "Подтверждение базы данных");
define("LANINS_039", "Пожалуйста, убедитесь, что вы заполнили все поля, особенно: Сервер MySQL, MySQL Имя пользователя и База данных MySQL (Они всегда требуются Сервером MySQL)");
define("LANINS_040", "Ошибки");
define("LANINS_041", "e107 не смогла установить соединение с MySQL, используя информацию, которую вы ввели. <br />Пожалуйста, перейдите к предыдущей странице и убедитесь в правильности настроек.");
define("LANINS_042", "Соединение с MySQL установлено и проверено.");
define("LANINS_043", "Невозможно создать базу данных. Пожалуйста, убедитесь в том, что у Вас есть права на создание базы данных на сервере.");
define("LANINS_044", "База данных создана успешно.");
define("LANINS_045", "Пожалуйста, нажмите на кнопку, чтобы перейти к следующей стадии установки.");
define("LANINS_046", "5");
define("LANINS_047", "Информация о Главном Администраторе");
define("LANINS_047a", "Администрация");
define("LANINS_048", "Назад к последнему шагу");
define("LANINS_049", "Пароли не совпадают, пожалуйста, вернитесь и введите ещё раз.");
define("LANINS_050", "XML расширение");
define("LANINS_051", "Установлено");
define("LANINS_052", "Не установлено");
define("LANINS_053", "e107 0.7.x требует установленного PHP XML расширения. Свяжитесь с Администрацией хостинга, или почитайте об этом на <a href='http://php.net/manual/en/ref.xml.php' target='_blank'>php.net</a> перед продолжением");
define("LANINS_054", "Проверка существования выбранной базы данных прошла успешно.");
define("LANINS_055", "Подтверждение установки");
define("LANINS_055a", "Подтвердить");
define("LANINS_056", "6");
define("LANINS_057", " e107 теперь имеет всю необходимую информацию для завершения установки<br /><br />Пожалуйста, щелкните по кнопке, чтобы создать таблицы базы данных и сохранить все Ваши настройки.");
define("LANINS_058", "7");
define("LANINS_060", "Невозможно прочитать файл данных sql

Пожалуйста, убедитесь что файл <b>core_sql.php</b> существует в каталоге <b>/e107_admin/sql</b>");
define("LANINS_061", "e107 не смог создать нужные таблицы в базе данных.<br /><br />Пожалуйста, очистите базу данных и устраните все проблемы перед тем как попробовать ещё раз.");
define("LANINS_062", "[b]Добро пожаловать на Ваш новый веб-сайт![/b]
e107 была успешно установлена и теперь готова для принятия контента.<br />Ваш Админцентр [link=e107_admin/admin.php]находится здесь[/link], нажмите, чтобы перейти туда сейчас. Вам потребуется ввести имя пользователя и пароль, которые вы указали в процессе установки.

[b]Поддержка[/b]
Домашняя страница e107: [link=http://e107.org]http://e107.org[/link], здесь вы найдете FAQ и документацию.
Форумы: [link=http://e107.org/e107_plugins/forum/forum.php]http://e107.org/e107_plugins/forum/forum.php[/link]
Сообщество разработчиков плагинов: [link=http://www.e107coders.org]http://e107coders.org[/link]

[b]Загрузки[/b]
Плагины: 
[link=http://plugins.e107.org]http://plugins.e107.org[/link]
Темы: [link=http://themes.e107.org]http://themes.e107.org[/link]

Спасибо за то, что вы пробуете e107, мы надеемся, что эта система удовлетворит нужды вашего веб-сайта.
(Вы можете удалить это сообщение, войдя в раздел администрирования.)");
define("LANINS_063", "Добро пожаловать в e107");
define("LANINS_069", "e107 успешно установлена!

Из соображений безопасности вы должны сейчас установить права доступа к файлу<br /><b>e107_config.php</b> равными 644.

Также удалите файл install.php с Вашего сервера после того, как Вы нажмёте на кнопку внизу.");
define("LANINS_070", "e107 не смогла сохранить главный файл конфигурации на ваш сервер.

Пожалуйста, убедитесь что у файла <b>e107_config.php</b> установлены корректные права доступа");
define("LANINS_071", "Завершение установки");
define("LANINS_071a", "Готово");
define("LANINS_071b", "Ошибка при окончании установки");
define("LANINS_071c", "Завершено с ошибками");
define("LANINS_072", "Имя пользователя администратора");
define("LANINS_073", "Это имя пользователя, которое вы будете использовать для доступа на сайт. Если вы желаете, можете использовать это имя и в качестве вашего Отображаемого имени");
define("LANINS_074", "Отображаемое имя Администратора");
define("LANINS_075", "Это имя будет видно пользователям в сообщениях, на форуме и т.п. Если вы хотите использовать то же имя, что и имя пользователя, оставьте это поле пустым.");
define("LANINS_076", "Пароль Администратора");
define("LANINS_077", "Введите пароль, с которым вы будете входить в систему");
define("LANINS_078", "Подтверждение пароля");
define("LANINS_079", "Введите пароль Администратора еще раз для подтверждения");
define("LANINS_080", "Email Администратора");
define("LANINS_081", "Введите ваш email-адрес");
define("LANINS_082", "пользователь@сайт.ru");
define("LANINS_083", "Ошибки, сообщенные MySQL:");
define("LANINS_084", "Инсталлятор не может установить соединение с базой данных");
define("LANINS_085", "Инсталлятор не может выбрать базу данных:");
define("LANINS_086", "<b>Требуется</b> заполнить поля: Имя, Пароль и Адрес электронной почты администратора. Пожалуйста, вернитесь на предыдущую страницу и убедитесь, что данные введены корректно.");
define("LANINS_087", "Разное");
define("LANINS_088", "Начало");
define("LANINS_089", "Загрузки");
define("LANINS_090", "Пользователи");
define("LANINS_091", "Предложить новость");
define("LANINS_092", "Свяжитесь с нами");
define("LANINS_093", "Разрешает доступ к приватным пунктам меню");
define("LANINS_094", "Пример класса приватного форума");
define("LANINS_095", "Проверка целостности");
define("LANINS_096", "Последние комментарии");
define("LANINS_097", "[далее ...]");
define("LANINS_098", "Новости");
define("LANINS_099", "e107 CMS");
define("LANINS_100", "Последние сообщения форума");
define("LANINS_101", "Обновить настройки меню");
define("LANINS_102", "Дата / Время");
define("LANINS_103", "Плагины e107");
define("LANINS_104", "Проверено");
define("LANINS_105", "Имя или префикс базы данных, начинающиеся с цифр с последующими буквами “e” или “E”  - недопустимы. <br /> Название базы данных или префик не могут быть пустыми.");
define("LANINS_106", "ВНИМАНИЕ: е107 не может произвести запись в перечисленные директории и/или файлы. Если установка E107 все же не прервалась, то это значит, что некоторые возможности будут недоступны. <br /><br />Вы должны изменить права доступа к файлу для использования этих возможностей");
define("LANINS_107", "e107_config.php не пуст");
define("LANINS_108", "Возможно, Вы уже запустили установку");
define("LANINS_DB_UTF8_LABEL", "Принудительно использовать UTF-8 для базы данных?");
define("LANINS_DB_UTF8_CAPTION", "Кодировка MySQL:");
define("LANINS_DB_UTF8_TOOLTIP", "Если отмечено, инсталлятор попытается сделать базу данных UTF-8 совместимой. UTF-8 база данных необходима для совместимости с будущими версиями e107.");
define("LANINS_109", "Начато");
define("LANINS_110", "Готово");
define("LANINS_111", "Темы e107");
define("LANINS_112", "Справочник e107");
define("LANINS_113", "");
define("LANINS_121", "e107_config.php уже существует!");
define("LANINS_122", "Возможно, Вы уже запустили установку");
define("LANINS_123", "Информация об отладке");
define("LANINS_124", "Отслеживание ошибок");
define("LANINS_125", "Неверное действие");
define("LANINS_125a", "Ошибка");
define("LANINS_WELCOME", "[b]Добро пожаловать на Ваш новый сайт![/b] Установка e107 прошла успешно, и система готова к обработке Ваших данных. Ваша админка доступна по [link=e107_admin/admin.php]следующей ссылке[/link], кликните чтобы перейти туда прямо сейчас. Вам нужно будет ввести логин и пароль, которые Вы вводили во время установки. [b]Поддержка[/b] 
[link=http://e107.org/]Сайт e107[/link] [link=http://e107.org/support]Форумы e107[/link] [link=http://wiki.e107.org/]Справочник e107[/link] 
Благодарим за использование e107.");
define("LANINS_NEWS", "[b]Добро пожаловать![/b] e107 - это система управления контентом, написанная на PHP и использующая популярную бесплатную систему MySQL для хранения данных. Она абсолютно бесплатна, полностью персонифицируема, и постоянно обновляется. [list][link=http://e107.org/content/Learn-all-about-e107]Все, что Вы хотите знать о e107[/link]*[link=http://e107.org/content/About-Us:The-Team]Разработчики | Переводчики | Поддержка[/link]*[link=http://wiki.e107.org/]Библиотека Wiki[/link][/list]");


?>