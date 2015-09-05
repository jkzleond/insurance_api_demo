<?php
class UserController extends SF_BaseController
{
	public function loginAction()
	{
		$this->view->disable();
		$http_request = new HttpRequest();

		print_r($_SERVER);
		
		$header = array(
			'Host:106.37.195.128',
			'User-Agent:Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:40.0) Gecko/20100101 Firefox/40.0',
			'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'Accept-Language:zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
			'Referer:http://106.37.195.128/chinalifepcsfa/system/userLogin.do',
			'Connection:keep-alive'	
		);
	
		$data = 'platformType=0&userId=530123197902182620&password=sp182620';
		$http_respone = $http_request->post('http://106.37.195.128/chinalifepcsfa/system/userLogin.do', $header, $data);
		if( isset($http_respone->headers['Location']) )
		{
			$location = $http_respone->headers['Location'];
			$cookies = $http_respone->cookies;
			
			$header2 = array(
				'Host:106.37.195.128',
				'User-Agent:Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:40.0) Gecko/20100101 Firefox/40.0',
				'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
				'Accept-Language:zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
				'Referer:http://106.37.195.128/chinalifepcsfa/system/userLogin.do',
				'Connection:keep-alive'
			);

			$http_respone2 = $http_request->get($location, $header2, $cookies);
			preg_match('@href="(/chinalifepcsfa/user/electronicInsurance.do\?.*)"@Ui', $http_respone2->content, $matches);
			$entrance_href = 'http://106.37.195.128'.$matches[1];
			
			$header3 = array(
				'Host:106.37.195.128',
				'User-Agent:Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:40.0) Gecko/20100101 Firefox/40.0',
				'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
				'Accept-Language:zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
				'Connection:keep-alive'
			);

			$http_respone3 = $http_request->get($entrance_href, $header3, $cookies);
			$final_url = $http_respone3->headers['Location'];

			$_SESSION['emu_url'] = $final_url;
			
			$final_header = array(
				'Host:106.37.195.128:7011',
				'User-Agent:Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:40.0) Gecko/20100101 Firefox/40.0',
				'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
				'Accept-Language:zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
				'Connection:keep-alive'
			);
			$final_http_response = $http_request->get($final_url, $final_header, $cookies);

			$_SESSION['emu_cookies'] = $final_http_response->cookies;
		}
		else
		{
			echo json_encode(array(
				'success' => false,
				'err_msg' => '用户名或密码错误!'
			));
		}
	}
}