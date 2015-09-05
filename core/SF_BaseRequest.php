<?php
class SF_BaseRequest extends SF_AbstractInjectable
{
	protected function _initialize()
	{
		$this->_get = $_GET;
		$this->_post = $_POST;
		$this->_params = $_REQUEST;
		$this->_server = $_SERVER;
	}

	/**
	 * 获取请求参数($_REQUEST)
	 * @return array
	 */
	public function getParams()
	{
		return $this->_params;
	}

	/**
	 * 获取GET参数
	 * @param  string $key
	 * @return mixed
	 */
	public function get($key=null)
	{
		if(!$key)
		{
			return $this->_get; 
		}
		else
		{
			return isset( $this->_get[$key] ) ? $this->_get[$key] : null; 
		}
	}

	/**
	 * 获取Post参数
	 * @param string $key
	 * @return mixed
	 */
	public function getPost($key=null)
	{
		if(!$key)
		{
			return $this->_post; 
		}
		else
		{
			return isset( $this->_post[$key] ) ? $this->_post[$key] : null; 
		}
	}

	/**
	 * 获取Put参数
	 * @param  string $key
	 * @return mixed
	 */
	public function getPut($key)
	{

	}

	/**
	 * 获取原始请求体
	 * @return string
	 */
	public function getRawBody()
	{
		return file_get_contents('php://input');
	}

	/**
	 * 获取原始请求体的json(json_decode后)
	 * @param  bool $is_assoc 是否解码成关联数组
	 * @return object|array
	 */
	public function getJsonRawBody($is_assoc=false)
	{
		$json = file_get_contents('php://input');
		return json_decode($json, $is_assoc);
	}
}