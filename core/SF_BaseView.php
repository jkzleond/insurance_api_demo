<?php
class SF_BaseView extends SF_AbstractInjectable
{
	protected $_vars = array();
	protected $_disabled = false;
	protected $_renderView = null; //准备渲染的视同名称(控制器名称与Action名称的组合)
	protected $_engine = null; //模板引擎
	protected $_dir = null;
	protected $_cache_dir = null;

	protected function _initialize()
	{	

	}

	/**
	 * 设置视图变量
	 * @param array $vars
	 */
	public function setVars($vars)
	{
		$this->_vars = $vars;
	}

	/**
	 * 获取视图变量
	 * @return array
	 */
	public function getVars()
	{
		return $this->_vars;
	}

	/**
	 * 禁止视图,将不会进行按最后执行控制器名称的最后Action名称查找模板的自动渲染
	 */
	public function disable()
	{
		$this->_disabled = true;
	}

	/**
	 * 选择一个视图文件渲染, 代替默认的最后执行的控制器的最后Action
	 * @param  string $renderView //控制器名称与Action的组合,如 'book/list'
	 * @return 
	 */
	public function pick($renderView)
	{
		$this->_renderView = $renderView;
	}

	/**
	 * 获取要渲染的视图(模板)文件路径(不含扩展名)
	 * @return string
	 */
	public function getTemplatePath()
	{
		if($this->_renderView) return $this->_dir.'/'.$this->_renderView.$this->_engine->getExtName();
		$controller_name = $this->getDI()->get('dispatcher')->getControllerName();
		$action_name = $this->getDI()->get('dispatcher')->getActionName();
		return $this->_dir.'/'.$controller_name.'/'.$action_name.$this->_engine->getExtName();
	}

	/**
	 * 设置模板引擎
	 * @param SF_BaseViewEngine $engine
	 */
	public function setEngine($engine)
	{
		$this->_engine = $engine;
	}

	/**
	 * 获取模板引擎
	 * @return SF_BaseViewEngine
	 */
	public function getEngine()
	{
		return $this->_engine;
	}

	/**
	 * 设置视图目录
	 * @param $dir
	 */
	public function setDir($dir)
	{
		$this->_dir = $dir;
	}

	/**
	 * 设置缓存目录
	 * @param string $dir
	 */
	public function setCacheDir($dir)
	{
		$this->_cache_dir = $dir;
	}

	/**
	 * 渲染视图
	 */
	public function render()
	{
		ob_start();
		$this->_engine->render($this->getTemplatePath(), $this->getVars());
		return ob_get_clean();
	}

}