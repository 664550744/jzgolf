<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login {

    public function isLogin()
    {
		
		if(!isset($_SESSION['login'])){
			
		
			//redirect(site_url('Welcome/login'));
			$login_redirect_uri = site_url(uri_string());
			$redirect_uri =site_url('User/login');
			echo $redirect_uri;
			$_SESSION['login_redirect_uri']=$login_redirect_uri;
			
			$wxLogin_url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe2963362fb41fb4e&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
			redirect($wxLogin_url);
			
			
                                
		}
    }
    /**
     * +----------------------------------------------------------------------
     * | Author 王文华
     * +----------------------------------------------------------------------
     * | qq 664550744
     * +----------------------------------------------------------------------
     * | e-mail 664550744@qq.com
     * +----------------------------------------------------------------------
     * | DateTime 2018-08-28
     * +----------------------------------------------------------------------
     * | copyright [copyright]
     * +----------------------------------------------------------------------
     * | license [license]
     * +----------------------------------------------------------------------
     * | version [version]
     * +----------------------------------------------------------------------
     * @return [type：boole] [登录状态]
     */
    public function login_ok()
    {
		
		if(!isset($_SESSION['login'])){
			
			return false ;                  
		}else{
			return true;
		}
    }
	
}