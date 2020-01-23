<?php
use Igoframework\Core\App;
use Igoframework\Core\Routing\Router;

$app = new App();

// правила маршрутизации для административной части сайта
Router::add('^admin/?(?P<action>[a-z-]+)/?(?P<param>[0-9]+)?$', ['controller' => 'news', 'prefix' => 'admin']);
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);
Router::add('^admin', ['controller' => 'news', 'action' => 'index', 'prefix' => 'admin']);

// правила маршрутизации по умолчанию
Router::add('^$', ['controller' => 'main', 'action' => 'index']);
Router::add('^news/?(?P<action>[a-z-]+)/?(?P<param>[0-9]+)?$', ['controller' => 'main']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

// перенаправление на нужный маршрут
Router::dispatch($query);