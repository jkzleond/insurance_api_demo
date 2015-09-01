<?php
class EX_XMLView extends SF_BaseView
{
	protected $xml_version = '1.0';
	protected $xml_encoding = 'UTF-8';

	public function render()
	{
		header('Content-Type: text/xml');
		$declare = '<?xml version="'.$this->xml_version.'" encoding="'.$this->xml_encoding.'" ?>';
		return $declare.'<root>'.$this->_array2xml($this->_vars).'</root>';
	}

	/**
	 * 设置输出xml版本
	 * @param string $version
	 */
	public function setXMLVersion($version)
	{
		$this->xml_version = $version;
	}

	/**
	 * 设置输出xml编码
	 * @param string $encoding
	 */
	public function setXMLEcoding($encoding)
	{
		$this->_xml_encoding = $encoding;
	}

	/**
	 * 数组转XML(递归)
	 * @param  array $array
	 * @return string
	 */
	protected function _array2xml($array)
	{
		$xml = '';

		foreach($array as $key => $value)
		{
			$node_value = null;

			if( is_array($value) )
			{
				$node_value = $this->_array2xml($value);
			}
			else
			{
				$node_value = $value;
			}

			//如果键为整形(数字),节点将视为与父级同级
			if( is_numeric($key) )
			{
				$xml .= '<row>'.$node_value.'</row>';
			}
			else
			{
				$xml .= '<'.$key.'>'.$node_value.'</'.$key.'>';
			}
		}

		return $xml;
	}
}