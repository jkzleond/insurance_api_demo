<?php
/**
 * 配置组类
 */
class SF_BaseConfigure extends SF_AbstractInjectable
{
	protected $_name = ''; //配置组名称
	protected $_config = null;
	protected $_parent = null; //父级

	/**
	 * @param array $config
	 */
	public function __construct($config=null)
	{
		$this->_config = $config ? $config : array();
		parent::__construct();
	}

	protected function _initialize()
	{
		
	}

	/**
	 * 设置配置(数组形式)
	 * @param array $config
	 */
	public function setConfig($config)
	{
		$this->_config = $config;
	}

	/**
	 * 获取配置组名称
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}

	/**
	 * 设置配置组名称
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->_name = $name;
	}

	/**
	 * 设置父级配置
	 * @param SF_BaseConfigure $parent
	 */
	public function setParent($parent)
	{
		$this->_parent = $parent;
	}

	/**
	 * 获取父级配置
	 * @return SF_BaseConfigure
	 */
	public function getParent()
	{
		return $this->_parent;
	}

	/**
	 * 获取配置
	 * @param  $name 配置名称
	 * @param  $is_require 是否必须,如果设置成true而不存在该配置的就会报异常,默认true
	 * @return array|null
	 */
	public function get($name, $is_require=true)
	{
		if( isset($this->_config[$name]) )
		{
			//如果这个配置项还是数组, 则转换成配置组对象
			if( is_array($this->_config[$name]) )
			{
				$config_obj = new static($this->_config[$name]);
				$config_obj->setParent($this);
				$config_obj->setName($name);
				$this->_config[$name] = $config_obj;
			}
			return $this->_config[$name];
		}

		if( $is_require )
		{
			throw new Exception($this->getChainName().$name.' is not exists');
		}

		return null;
	}

	/**
	 * 设置配置
	 * @param string $name 配置组名称
	 * @param array $config
	 */
	public function set($name, $config)
	{
		$this->_config[$name] = $config;
	}

	public function __get($attr_name)
	{
		return $this->get($attr_name);
	}

	/**
	 * 获取配置链
	 * @return string
	 */
	public function getChainName()
	{
		if($this->_parent) return $this->_parent->getChainName().$this->_name.'->';
		return 'config->';
	}

}