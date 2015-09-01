<?php
class SF_BaseDispatcher extends SF_AbstractInjectable
{

	protected $_controller_name = null;
	protected $_action_name = null;
	protected $_controller_suffix = 'Controller';
	protected $_action_suffix = '';

	/**
	 * 初始化方法,必须实现的父类抽象方法
	 * @return 
	 */
	protected function _initialize()
	{

	}

	/**
	 * 设置控制器后缀(默认未Controller)
	 * @param string $controller_suffix
	 */
	public function setControllerSuffix($controller_suffix)
	{
		$this->_controller_suffix = $controller_suffix;
	}

	/**
	 * 设置将要执行的控制器名称
	 * @param string $controller_name
	 */
	public function setControllerName($controller_name)
	{
		$this->_controller_name =  $controller_name;
	}

	/**
	 * 获取当前控制器名称
	 * @return string
	 */
	public function getControllerName()
	{
		return $this->_controller_name;
	}

	/**
	 * 设置Action后缀(默认没有)
	 * @param string $action_suffix
	 */
	public function setActionSuffix($action_suffix)
	{
		$this->_action_suffix = $action_suffix;
	}

	/**
	 * 设置将要执行的Action名称
	 * @param string $action_name
	 */
	public function setActionName($action_name)
	{
		$this->_action_name = $action_name;
	}

	/**
	 * 获取当前Action名称
	 * @return string
	 */
	public function getActionName()
	{
		return $this->_action_name;
	}

	/**
	 * 执行控制器的Action
	 * @return
	 */
	public function dispatch()
	{
		$this->event_manager->trigger($this, 'dispatch:beforeControllerCreate'); //触发控制器创建前事件

		$controller_class_name = ucfirst( strtolower($this->_controller_name) ).$this->_controller_suffix;

		$controller = new $controller_class_name();

		$this->event_manager->bind('dispatch:afterControllerCreate', $controller); //绑定当前控制器实例为事件处理器

		$this->event_manager->trigger($this, 'dispatch:afterControllerCreate'); //创建触发控制器创建后事件

		$action = $this->_action_name.$this->_action_suffix;


		if( !method_exists($controller, $action) ) throw new Exception('controller '.$this->_controller_name.' has not action '.$this->_action_name);
		call_user_func(array($controller, $action));
	}
}