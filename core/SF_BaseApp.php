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
		$controller_name = $router->getControllerName();
		$action_name = $router->getActionName();
		
		$dispatcher = $di->get('dispatcher');
		$dispatcher->setControllerName($controller_name);
		$dispatcher->setActionName($action_name);
		$dispatcher->dispatch();

		$view = $di->get('view');
		echo $view->render();
		exit();
	}
}