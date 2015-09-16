<?php
class SF_BaseRouter extends SF_AbstractInjectable
{
	const RESTFUL_MODE = 0;
	const QUERY_STRING_MODE = 1;
	protected $_mode = 0;
	protected $_routes = array();
	protected $_default_controller_name = 'index';
	protected $_default_action_name = 'index';
	protected $_controller_name = '';
	protected $_action_name = '';
	protected $_parameters = null;

	protected function _initialize()
	{
		
	}

	public function parse()
	{
		if($this->_mode == SF_BaseRouter::RESTFUL_MODE) //restful 模式
		{
			if( !isset($_GET['_url']) ) return;
			$url = $_GET['_url'];

			$request_method = $_SERVER['REQUEST_METHOD'];

			$lambda = <<<FUNC
					if(\$matches[1]){
						return '(?P<'.rtrim(\$matches[1], ':').'>'.\$matches[2].')';
					}else{
						return '('.\$matches[2].')';
					}	
FUNC;

			if( isset($this->_routes[$request_method]) )
			{
				foreach($this->_routes[$request_method] as $pattern => $paths)
				{
					$reg = '@^'.preg_replace_callback('/\{(.*:)?([^:]*)\}/Uis', create_function('$matches', $lambda), $pattern).'$@'; // 使用create_function兼容5.2
					
					if( preg_match($reg, $url, $matches) )
					{
						if(is_string($paths))
						{
							$paths = explode('/', $paths);

							if( isset($paths[0]) )
							{
								$this->_controller_name = $paths[0];
							}

							if( isset($paths[1]) )
							{ 
								$this->_action_name = $paths[1];
							}

						}
						elseif(is_array($paths))
						{
							if( isset($paths['controller']) )
							{
								$this->_controller_name = $paths['controller'];
							}

							if( isset($paths['action']) )
							{ 
								$this->_action_name = $paths['action'];
							}
						}

						array_splice($matches, 0, 1);
						$this->_parameters = $matches;

						return;
					}
				}
			}

			if( isset($this->_routes['ALL']) )
			{
				foreach($this->_routes['ALL'] as $pattern => $paths)
				{
					$reg = '@^'.preg_replace_callback('/\{(.*:)?(.*)\}/', create_function('$matches', $lambda), $pattern).'$@'; // 使用create_function兼容5.2
					if( preg_match($reg, $url, $matches) )
					{
						if(is_string($paths))
						{
							$paths = explode('/', $paths);

							if( isset($paths[0]) )
							{
								$this->_controller_name = $paths[0];
							}

							if( isset($paths[1]) )
							{ 
								$this->_action_name = $paths[1];
							}

						}
						elseif(is_array($paths))
						{
							if( isset($paths['controller']) )
							{
								$this->_controller_name = $paths[0];
							}

							if( isset($paths['action']) )
							{ 
								$this->_action_name = $paths[1];
							}
						}

						array_splice($matches, 0, 1);
						$this->_parameters = $matches;

						return;
					}
				}
			}

			$paths = explode('/', ltrim($url, '/'));
			$this->_controller_name = isset($paths[0]) ? $paths[0] : null;
			$this->_action_name = isset($paths[1]) ? $paths[1] : null;
			array_splice($paths, 0, 2); //删除前两个(控制器名称和action名称),剩下的就是action parameters
			$this->_parameters = $paths;
		}
		elseif($this->_mdoe == SF_BaseRouter::QUERY_STRING_MODE) //查询字符串模式
		{
			$this->_controller_name = $_GET['c'];
			$this->_action_name = $_GET['a'];
		}
	}

	/**
	 * 设置路由模式
	 * @param int $mode 可以是SF_BaseRouter::RESTFUL_MODE 和 SF_BaseRouter::QUERY_STRING_MODE
	 */
	public function setMode($mode)
	{
		$this->_mode = $mode;
	}

	/**
	 * 获取路由模式
	 * @return int
	 */
	public function getMode()
	{
		return $this->_mode;
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

	public function getParameters()
	{
		return $this->_parameters;
	}

	/**
	 * 添加路由(匹配所有方法的请求)
	 * @param string $pattern
	 * @param string|array $paths
	 */
	public function add($pattern, $paths)
	{
		$this->_routes['ALL'][$pattern] = $paths;
	}

	/**
	 * 添加GET路由(只匹配TGET方法的请求)
	 * @param string $pattern
	 * @param string|array $paths
	 */
	public function addGet($pattern, $paths)
	{
		$this->_routes['GET'][$pattern] = $paths;
	}

	/**
	 * 添加POST路由
	 * @param string $pattern
	 * @param string|array $paths
	 */
	public function addPost($pattern, $paths)
	{
		$this->_routes['POST'][$pattern] = $paths;
	}

	/**
	 * 添加PUT路由
	 * @param string $pattern
	 * @param string|array $paths
	 */
	public function addPut($pattern, $paths)
	{
		$this->_routes['PUT'][$pattern] = $paths;
	}

	/**
	 * 添加DELETE路由
	 * @param string $pattern
	 * @param string|array $paths
	 */
	public function addDelete($pattern, $paths)
	{
		$this->_routes['DELETE'][$pattern] = $paths;
	}
}