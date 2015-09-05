<?php
class HttpRequest
{
	/**
	 * 通过GET方法对指定url发送请求
	 * @param  string  $url
	 * @param  array  $header http请求头
	 * @param  string  $cookie
	 * @param  int $headerinfo 是否接受响应头
	 * @return HttpResponse
	 */
	public function get($url, $header = array(), $cookie = "", $headerinfo = 1) {
		$process = curl_init();
		curl_setopt( $process, CURLOPT_URL, $url );
		curl_setopt( $process, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $process, CURLOPT_HEADER, $headerinfo );
		curl_setopt( $process, CURLOPT_HTTPHEADER, $header ); // 设置头信息的地方
		curl_setopt( $process, CURLOPT_COOKIE, $cookie );
		$res = curl_exec ( $process );
		curl_close ( $process );
		$resp = new HttpResponse($res);
		return $resp;
	}

	/**
	 * 通过POST方法对指定url发送请求
	 * @param  string  $url 
	 * @param  array  $header http请求头
	 * @param  string  $data
	 * @param  string  $cookie
	 * @param  int $headerinfo 是否接收响应头
	 * @return HttpRespone
	 */
	public function post($url, $header = array(), $data, $cookie = "", $headerinfo = 1) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt ( $ch, CURLOPT_HEADER, $headerinfo); 
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 0 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 120 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_COOKIE, $cookie );
		$res = curl_exec ( $ch );
		curl_close ( $ch );
		$resp = new HttpResponse($res);
		return $resp;
	}
}