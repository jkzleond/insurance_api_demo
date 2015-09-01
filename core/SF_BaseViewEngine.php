<?php
/**
 * 基本模板引擎,支持原生的php模板
 */
class SF_BaseViewEngine extends SF_AbstractInjectable
{
	protected $_view = null;
	protected $_ext_name = '.php';
	/**
	 * @param SF_BaseView $view
	 */
	public function __construct($view)
	{
		$this->_view = $view;
		parent::__construct();
	}

	protected function _initialize()
	{

	}
	
	/**
	 * 设置模板文件扩展名
	 * @param string $ext_name
	 */
	public function setExtName($ext_name)
	{
		$this->_ext_name = $ext_name;
	}

	/**
	 * 获取模板文件扩展名
	 * @return string
	 */
	public function getExtName()
	{
		return $this->_ext_name;
	}


	public function render($path, $params=null)
	{
		if($params) extract($params);
		include $path;
	}

}