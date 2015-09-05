<?php
class SF_BaseApp extends SF_AbstractInjectable
{
	public function __construct()
	{
		$this->_initialize();
	}

	protected function _initialize()
	{

	}  

	public function start()
	{
		$di = $this->getDI();
		$router = $di->get('router');
		$router->parse();
		$controller_name = $router->getControllerName();
		$action_name = $router->getActionName();
		$parameters = $router->getParameters();

		session_start();

		$dispatcher = $di->get('dispatcher');
		$dispatcher->setControllerName($controller_name);
		$dispatcher->setActionName($action_name);
		$dispatcher->setParameters($parameters);
		$dispatcher->dispatch();

		$view = $di->get('view');
		if( $view->isEnabled() )	echo $view->render();
		exit();
	}
}