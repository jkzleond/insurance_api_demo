<?php
class SF_BaseEventManager extends SF_AbstractInjectable
{
	protected $_handlers = null;

	protected function _initialize()
	{
		$this->_handlers = array();
	}

	/**
	 * 触发事件
	 * @param  object $target 事件目标(触发事件的对象)
	 * @param  string $event_name 事件名称
	 * @param  mixed  $addon_data 附加信息
	 * @return SF_BaseEventManager 返回自身支持链式调用
	 */
	public function trigger($target, $event_name, $addon_data=null)
	{
		$event_segment = explode(':', $event_name);
		$event_type = $event_segment[0];
		$event_short_name = $event_segment[1];

		if(!empty($this->_handlers[$event_type]))
		{
			foreach($this->_handlers[$event_type]['_hdl'] as $handler)
			{
				if( $this->_execHandler($handler, array($target, $event_type, $event_short_name, $addon_data)) === false) break;
			}

			if( !empty($this->_handlers[$event_type][$event_short_name]) )
			{
				foreach($this->_handlers[$event_type][$event_short_name] as $handler)
				{
					if( $this->_execHandler($handler, array($target, $event_type, $event_short_name, $addon_data)) === false) break;
				}
			}
		}
	}

	/**
	 * 绑定事件
	 * @param  string                  $event_name 事件名
	 * @param  string|callable|object| $handler 事件处理器(函数名,对象方法,观察者对象)
	 * @return SF_BaseEventManager 返回自身支持链式调用
	 */
	public function bind($event_name, $handler)
	{
		$event_segment = explode(':', $event_name);
		$event_type = $event_segment[0];
		$event_short_name = $event_segment[1];

		if( empty($this->_handlers[$event_type]) )
		{
			$this->_handlers[$event_type] = array(
				'_hdl' => array() //_hdl用于存储直接绑定事件类型而没绑定事件名称的事件
			);
		}

		if( $event_short_name )
		{
			if( empty($this->_handlers[$event_type][$event_short_name]) )
			{
				$this->_handlers[$event_type][$event_short_name] = array();
			}

			$this->_handlers[$event_type][$event_short_name][] = $handler;	
		}
		else
		{
			$this->_handlers[$event_name]['_hdl'][] = $handler;
		}
	}

	/**
	 * 执行handler
	 * @param  mixed $handler
	 * @param  array $arguments
	 * @return mixed
	 */
	protected function _execHandler($handler, $arguments)
	{
		if( is_callable($handler) )
		{
			return call_user_func_array($arguments);
		}
		elseif( is_object($handler) )
		{
			$event_short_name = $arguments[2];
			$method_name = $event_short_name;
			
			if( method_exists($handler, $method_name) )
			{
				return call_user_func_array( array($handler, $method_name), $arguments );
			}
		}
	}
}