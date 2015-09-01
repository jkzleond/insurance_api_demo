<?php
/**
 * 依赖注抽象类
 */
class SF_BaseDI
{
	protected static $_current_di = null;
	protected $_sloved = null;
	protected $_slovers = null;


	public static function getCurrentDI()
	{
		return self::$_current_di;
	}

	public function __construct()
	{
		$this->_sloved = array();
		$this->_slovers = array();
		self::$_current_di = $this;
	}

	/**
	 * 获取服务(取得依赖)
	 * @param  array $service_name
	 * @return object
	 */
	public function get($service_name)
	{
		if( isset($this->_sloved[$service_name]) )
		{
			return $this->_sloved[$service_name];
		}
		elseif( isset($this->_slovers[$service_name]) )
		{
			$this->_sloved[$service_name] = call_user_func( $this->_slovers[$service_name] );
			return $this->_sloved[$service_name];
		}

		throw new Exception('service '.$service_name.' must be injected in di');
	}

	/**
	 * 依赖注入
	 */
	public function set($service_name, $slover)
	{
		if( isset($this->_sloved[$service_name]) || isset($this->_slovers[$service_name]) )
		{
			throw new Exception('service '.$service_name.' has injected!');
		}
		$this->_slovers[$service_name] = $slover;
		return $this;
	}

	public function __get($attr_name)
	{
		return $this->get($attr_name);
	}

	public function __set($attr_name, $attr_value)
	{
		$this->set($attr_name, $attr_value);
	}
}