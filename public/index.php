<?php

$query = trim($_SERVER['REQUEST_URI'], '/');                        // текущий запрос из адресной строки

define('DEBUG', true);                                                      // режим отладки
define('WWW', __DIR__);                                                     // текущая директория
define('ROOT', dirname(__DIR__));                                      // корневая директория приложения
define('APP', dirname(__DIR__) . '/app');                              // главная папка приложения
define('CORE', dirname(__DIR__) . '/vendor/igoframework/core');        // папка с ядром приложения
define('LIBS', dirname(__DIR__) . '/vendor/igoframework/core/libs');   // папка с библиотеками
define('LAYOUT', 'default');                                                // шиблон по умолчанию
define('CONTROLLERS', 'App\Controllers\\');                                 // неймспейс контроллеров
define('MODELS', 'App\Models\\');                                           // неймспейс моделей
define('VIEWS', 'App\Views\\');                                             // неймспейс видов

require_once LIBS . '/functions.php';                                       // подключаем функции

require_once ROOT . '/vendor/autoload.php';                                 // подключаем автозагрузчик

require_once ROOT . '/config/route.php';                                    // подключаем маршрутизатор

