<?php
/**
 * php5.3以下不支持匿名函数,所以用这种方法代替
 */
class Slover
{
	public function config()
	{
		$configure = new SF_BaseConfigure();
		global $config;
		$configure->setConfig($config);
		return $configure;
	}

	public function request()
	{
		$request = new SF_BaseRequest();
		return $request;
	}

	public function router()
	{
		$router = new SF_BaseRouter();
		return $router;
	}

	public function dispatcher()
	{
		$dispatcher = new SF_BaseDispatcher();
		return $dispatcher;
	}

	public function view()
	{
		global $config;
		$view = new EX_XMLView();
		return $view;
	}

	public function db()
	{
		global $config;
		$db = new SF_BaseDbAdapter(array(
			'dsn' => $config->database->dsn,
			'user' => $config->database->user,
			'password' => $config->database->password
		));
		return $db;
	}

	public function event_manager()
	{
		$event_manager = new SF_BaseEventManager();
		return $event_manager;
	}
}

$slover = new Slover();

$di = new SF_BaseDI();

//注入配置服务
$di->set('config', array($slover, 'config'));
$di->set('event_manager', array($slover, 'event_manager'));
$di->set('request', array($slover, 'request'));
$di->set('router', array($slover, 'router'));
$di->set('dispatcher', array($slover, 'dispatcher'));
$di->set('view', array($slover, 'view'));
$di->set('db', array($slover, 'db'));