<?php
abstract class SF_AbstractInjectable
{
	public function __construct()
	{
		$this->_initialize();
	}

	protected abstract function _initialize();

	public function getDI()
	{
		$di = SF_BaseDI::getCurrentDI();
		if(!$di) throw new Exception('a di object must be instantialize before use it');
		return $di;
	}

	public function __get($attr_name)
	{
		$di = $this->getDI();
		return $di->get($attr_name);
	}
}