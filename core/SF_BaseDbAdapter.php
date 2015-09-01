<?php
class SF_BaseDbAdapter extends SF_AbstractInjectable
{
	protected $_pdo; //PDO对象
	protected $_options = null;
	public function __construct($options)
	{
		$this->_options = $options;
		parent::__construct();
	}

	protected function _initialize()
	{
		$dsn = $this->_options['dsn'];
		$user_name = $this->_options['user'];
		$password = $this->_options['password'];
		$this->_pdo = new PDO($dsn, $user_name, $password);
	}

	public function __call($method_name, $args)
	{
		//pdo方法委托
		return call_user_func_array( array($this->_pdo, $method_name), $args );
	}

	/**
	 * 查询
	 * @param  string $sql //sql语句
	 * @param  array  $bind //绑定参数
	 * @param  int    $fetch_style //fetch模式(PDO::FETCH_ASSOC, PDO::FETCH_NUM, PDO::FETCH_OBJECT等, 默认PDO::FETCH_ASSOC)
	 * @return mixed
	 */
	public function query($sql, $bind=null, $fetch_style=PDO::FETCH_ASSOC)
	{
		$stm = $this->_pdo->prepare($sql);
		$this->_bindValue($stm, $bind);

		$stm->execute();
		$result = $stm->fetchAll($fetch_style); 
		$stm->closeCursor();
		return $result;
	}

	/**
	 * 执行
	 * @param  string $sql  //sql语句
	 * @param  array  $bind //绑定参数
	 * @param  int    $fetch_style //fetch模式(PDO::FETCH_ASSOC, PDO::FETCH_NUM, PDO::FETCH_OBJECT等, 默认PDO::FETCH_ASSOC)
	 * @return mixed
	 */
	public function execute($sql, $bind=null)
	{
		$stm = $this->_pdo->prepare($sql);
		$this->_bindValue($stm, $bind);

		$result = $stm->execute();
		$stm->closeCursor();
		return $result;
	}

	/**
	 * 获取一个记录
	 * @param  string $sql  //sql语句
	 * @param  array  $bind //绑定参数
	 * @param  int    $fetch_style //fetch模式(PDO::FETCH_ASSOC, PDO::FETCH_NUM, PDO::FETCH_OBJECT等, 默认PDO::FETCH_ASSOC)
	 * @return mixed
	 */
	public function fetchOne($sql, $bind=null, $fetch_style=PDO::FETCH_ASSOC)
	{
		$stm = $this->_pdo->prepare($sql);
		$this->_bindValue($stm, $bind);

		$stm->execute();
		$result = $stm->fetch($fetch_style);
		$stm->closeCursor();
		return $result;
	}

	protected function _bindValue($stm, $bind)
	{
		if( !is_array($bind) ) return;
		foreach($bind as $key => $value)
		{
			if(is_array($value))
			{
				$stm->bindValue(':'.$key, $value[0], $value[1]); //$value[0]为值, $value[1]为参数类型
			}
			else
			{
				$stm->bindValue(':'.$key, $value);
			}
		}
	}
}