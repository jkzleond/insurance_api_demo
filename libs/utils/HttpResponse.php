<?php

/**
 * 获取http响应相关信息的类
 */
class HttpResponse
{
    protected $_raw_content = '';
    protected $_headers = null;
    protected $_cookies = null;
    protected $_content = null;
    
    public function __construct($_raw_content='')
    {
        $this->_raw_content = $_raw_content;
    }
    
    public function __get($prop_name)
    {
        $method_name = 'get'.ucfirst($prop_name);
        
        if( method_exists($this, $method_name) )
        {
            return call_user_func(array($this, $method_name));
        }
        else
        {
            return $this->$prop_name;
        }
    }
    
    public function getCookies()
    {
        if(is_null($this->_cookies))
        {
            preg_match_all('/Set-Cookie: (.*);.*\r\n/Uis', $this->_raw_content, $mc);
            $this->_cookies = implode(';', $mc[1]);
        }
        return $this->_cookies;
    }
    
    public function getContent()
    {
        if(is_null($this->_content))
        {
            preg_match('/(?:\r\n){2,}(.*)/is', $this->_raw_content, $mc);
            $this->_content = isset($mc[1]) ? trim($mc[1]) : '';
        }
        return $this->_content;
    }
    
    public function getHeaders()
    {
        if(is_null($this->_headers))
        {
            $this->_headers = array();
            
            preg_match('/HTTP\/\d+\.\d+ \d+ .*\r\n(.*)(?:\r\n){2,}/Uis', $this->_raw_content, $m);    
            
            $header_str = isset($m[1]) ? $m[1] : null;
            
            if($header_str)
            {    
                preg_match_all('/(.*: .*)\r\n/Uis', $header_str, $mh);
                foreach($mh[1] as $header)
                {
                    $header_arr = explode(': ', $header);
                          
                    $key = $header_arr[0];
                    $value = $header_arr[1];
                          
                    if($this->_headers and array_key_exists($key, $this->_headers))
                    {
                        if(!is_array($this->_headers[$key]))
                        {
                            $this->_headers[$key] = (array) $this->_headers[$key];
                        }
                        $this->_headers[$key][] = $value;
                    }
                    else
                    {
                        $this->_headers[$key] = $value;
                    }
                }
            }
        }
        return $this->_headers;
    }

    public function getRawContent()
    {
        return $this->_raw_content;
    }
}