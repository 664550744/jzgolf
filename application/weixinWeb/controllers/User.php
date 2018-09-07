<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    /**
     * Notes: 用户微信登录处理
     * User: wangwenhua
     * Date: 2018/8/31
     * Time: 上午10:24
     * qq: 664550744
     * e-mail:664550744@qq.com
     */
	public function login()
	{

		//print_r($this->input->get_post("code"));
		//
		//echo md5('664550744'.time());


		$code = $this->input->get_post("code");  
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxe2963362fb41fb4e&secret=143eb338b97e336e134a2f3b2bab3a9d&code=$code&grant_type=authorization_code";  
		$json = file_get_contents($url); 
		$arr = json_decode($json,true);

		$token = $arr['access_token'];  
		$openid = $arr['openid'];

		if(!isset($arr['unionid'])||empty($arr['unionid'])){
			//重定向浏览器 
			$redirect_uri =site_url('User/login');
			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe2963362fb41fb4e&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";

			header("Location: $url"); 
			//确保重定向后，后续代码不会被执行 
			exit;
		}

		//拿到token后就可以获取用户基本信息了  
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid ";  
		$json = file_get_contents($url);//获取微信用户基本信息  
		$arr = json_decode($json,true);

        $userSess = array(

            'wxopenid'   => $openid

        );

        $this->session->set_userdata($userSess);

		//登录到高球现场系统
		//
		$toke_golf = '8151a643031874e2e0e22041f790b7bd';
		$http_token = md5($toke_golf.$arr['unionid'].$arr['openid']);
		$data['token']=$http_token;
		$data['unionid']=$arr['unionid'];
		$data['wxopenid']=$arr['openid'];
		$data['alias']=$arr['nickname'];
		$data['photo']=$arr['headimgurl'];
		$data['sex']=$arr['sex'];
		$data['from']="jz_shop";
		$data['last_ip']=$this->input->ip_address();

		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, "http://golf.langem.net/app/index.php/User/shopLogin" );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Expect:"));
		$return = curl_exec ( $ch );
		curl_close ( $ch );

		$LoginResult = json_decode($return,1) ;
		if($LoginResult['code']==0){
			
			$userSess = array(
				'user_id'  => $LoginResult['user']['user_id'],
				'token_id'   => $LoginResult['user']['token_id'],
				'alias'     => $LoginResult['user']['alias'],
				'photo'     => $LoginResult['user']['photo'],
				'ID'     => $LoginResult['user']['ID'],
				'login' => TRUE
			);

			$this->session->set_userdata($userSess);
			$login_redirect_uri = $this->session->userdata('login_redirect_uri');
			$newdata = array('login_redirect_uri');
			$this->session->unset_userdata($newdata);
			redirect($login_redirect_uri);
		}else{
			print_r($return); 
		}
		

		

		
	}

    /**
     * Notes: 添加收货地址
     * User: wangwenhua
     * Date: 2018/8/31
     * Time: 上午10:26
     * qq: 664550744
     * e-mail:664550744@qq.com
     */
    public function addressAdd()
    {
        $this->load->library('login');
        $this->login->isLogin();
        $this->load->model('Cart_model');
        $num = $this->Cart_model->getNum($this->session->userdata('user_id'));
        $this->load->view('header.html');
        $this->load->view('address_add',array('title' => "添加收货地址" ));
        $this->load->view('footer.html',array('num'=>$num));
    }

    /**
     * Notes: 收货地址列表
     * User: wangwenhua
     * Date: 2018/8/31
     * Time: 上午10:27
     * qq: 664550744
     * e-mail:664550744@qq.com
     */
    public function addressList()
    {
        $this->load->library('login');
        $this->login->isLogin();
        $this->load->model('Cart_model');
        $num = $this->Cart_model->getNum($this->session->userdata('user_id'));
        $this->load->view('header.html');
        $this->load->view('address_list',array('title' => "收货地址" ));
        $this->load->view('footer.html',array('num'=>$num));
    }

    /**
     * Notes: 修改收货地址
     * User: wangwenhua
     * Date: 2018/8/31
     * Time: 上午10:27
     * qq: 664550744
     * e-mail:664550744@qq.com
     */
    public function addressEdit()
    {
        $this->load->library('login');
        $this->login->isLogin();
        $this->load->model('Cart_model');
        $num = $this->Cart_model->getNum($this->session->userdata('user_id'));
        $this->load->view('header.html');
        $this->load->view('address_edit',array('title' => "修改收货地址" ));
        $this->load->view('footer.html',array('num'=>$num));
    }
	
	
	
	
}
