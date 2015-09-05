<?php
class SF_BaseDispatcher extends SF_AbstractInjectable
{

	protected $_controller_name = null;
	protected $_action_name = null;
	protected $_controller_suffix = 'Controller';
	protected $_action_suffix = 'Action';
	protected $_parameters = null;

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
	 * 设置Action参数
	 * @param array|null $parameters
	 */
	public function setParameters($parameters)
	{
		$this->_parameters = $parameters;
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

		$controller_ref_class = new ReflectionClass($controller);

		$this->event_manager->bind('dispatch:afterControllerCreate', $controller); //绑定当前控制器实例为事件处理器

		$this->event_manager->trigger($this, 'dispatch:afterControllerCreate'); //创建触发控制器创建后事件

		$action = $this->_action_name.$this->_action_suffix;

		if( !$controller_ref_class->hasMethod($action) )
		{
			throw new Exception('controller '.$this->_controller_name.' has not action '.$this->_action_name);
		}
		
		$action_method_ref_class = $controller_ref_class->getMethod($action);
		$action_parameters = $action_method_ref_class->getParameters();
		$action_args = array();

		foreach($action_parameters as $action_parameter_rel_class)
		{
			$param_name = $action_parameter_rel_class->getName();
			$param_value = null;
			if( isset($this->_parameters[$param_name]) )
			{
				$param_value = $this->_parameters[$param_name];
			}
			elseif($action_parameter_rel_class->isOptional())
			{
				$param_value = $action_parameter_rel_class->getDefaultValue();
			}
			else
			{
				throw new Exception('Controller '.$controller_class_name.' Action '.$action.' need parameter '.$param_name);
			}
			$action_args[$param_name] = $param_value;
		}

		$action_method_ref_class->invokeArgs($controller, $action_args);
	}
}