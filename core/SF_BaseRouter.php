<?php
class SF_BaseRouter extends SF_AbstractInjectable
{
	protected $_default_controller_name = 'index';
	protected $_default_action_name = 'index';
	protected $_controller_name = '';
	protected $_action_name = '';

	protected function _initialize()
	{
		$this->_parseUrl();
	}

	protected function _parseUrl()
	{
		$request = $this->getDI()->get('request');
		$this->_controller_name = $request->get('c');
		$this->_action_name = $request->get('a');
	}

	/**
	 * 设置默认控制器名名称
	 * @param string $controller_name
	 */
	public function setDefaultControllerName($controller_name)
	{
		$this->_default_controller_name = $controller_name;
	}

	/**
	 * 设置默认Action名称
	 * @param string $action_name
	 */
	public function setDefaultActionName($action_name)
	{
		$this->_default_action_name = $action_name;
	}

	/**
	 * 获取控制器名称
	 * @return string
	 */
	public function getControllerName()
	{
		return $this->_controller_name ? $this->_controller_name : $this->_default_controller_name;
	}

	/**
	 * 获取Action名称
	 * @return string
	 */
	public function getActionName()
	{
		return $this->_action_name ? $this->_action_name : $this->_default_action_name;
	}

}