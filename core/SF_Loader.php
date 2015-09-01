<?php
class SF_Loader
{
	protected static $_dir_separator = '/'; // 目录分割符
	protected static $_prefix_separator = '_'; // 前缀分割符
	protected static $_class_file_ext = '.php'; //类文件扩展名
	protected $_dirs = null; //搜索路径
	protected $_prefix_map = null; //前缀映射
	protected $_suffix_map = null; //后缀映射
	protected $_namespace_map = null; //命名空间映射

	public function __construct()
	{
		$this->_dirs = array();
		$this->_prefix_map = array(
			'SF' => dirname(__FILE__)
		);
		$this->_suffix_map = array();
		$this->_namespace_map = array();
		spl_autoload_register(array($this, 'handler'));
	}

	public function handler($class_name)
	{
		$namespace = '';
		$namespace_pos = strrpos($class_name, "\\");

		//搜索命名空间
		if( !empty($this->_namespace_map) && $namespace_pos !== false)
		{
			$namespace = substr($class_name, $namespace_pos);
			$path .= ( isset($this->_namespace_map[$namespace]) ? $this->_namespace_map[$namespace] : '' );
			if( $this->_loadClass($path, $class_name) ) return;
		}

		$prefix = '';
		$prefix_pos = strrpos($class_name, self::$_prefix_separator);
		$path = '';

		//搜索前缀(不能同时具有命名空间和前缀)
		if( !empty($this->_prefix_map) && $prefix_pos !== false && $namespace_pos === false)
		{
			$prefix = substr($class_name, 0, $prefix_pos);
			$path .= (isset($this->_prefix_map[$prefix]) ? $this->_prefix_map[$prefix] : '' );

			if( $this->_loadClass($path, $class_name) ) return;
		}

		//搜索后缀
		if( !empty($this->_suffix_map) )
		{
			foreach($this->_suffix_map as $suffix => $suffix_path)
			{
				if( strlen($class_name) - strrpos($class_name, $suffix) == strlen($suffix) )
				{
					$path .= $suffix_path;
					break;
				}
			}

			if( $this->_loadClass($path, $class_name) ) return;
		}

		//搜索目录
		if( !empty($this->_dirs) )
		{
			foreach($this->_dirs as $dir)
			{
				if($this->_loadClass($dir, $class_name)) return;
			}
		}

		throw new Exception('can not load '.$class_name);
	}

	/**
	 * 注册搜索路径
	 * @param  array $dirs
	 */
	public function registerDirs($dirs)
	{
		$this->_dirs = array_merge($this->_dirs, $dirs);
	}

	/**
	 * 注册前缀映射
	 * @param array $map
	 */
	public function registerPrefix($map)
	{
		$this->_prefix_map = array_merge($this->_prefix_map, $map);
	}

	/**
	 * 注册后缀映射
	 * @param array $map
	 */
	public function registerSuffix($map)
	{
		$this->_suffix_map = array_merge($this->_suffix_map, $map);
	}

	/**
	 * 注册命名空间映射
	 * @param  array $map
	 */
	public function registerNamespace($map)
	{
		$this->_namespace_map = array_merge($this->_suffix_map, $map);
	}

	/**
	 * 加载类
	 * @param  $class_path 类路径
	 * @return bool
	 */
	protected function _loadClass($path, $class_name)
	{
		$class_file_path = $path.self::$_dir_separator.$class_name.self::$_class_file_ext;
		if( file_exists( $class_file_path ) )
		{
			include($class_file_path);
			return true;
		}
		return false;
	}

}