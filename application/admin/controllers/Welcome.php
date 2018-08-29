<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 */
	 
	public function index()
	{
		$this->load->library('login');
		$this->login->isLoginOut();  
		$data["username"] =$this->session->userdata('username');
		$this->load->view('page/welcome_message',$data);
	}
	/**
	 * 文件管理器
	 *
	 */
	public function fileManageer()
	{


		$this->load->helper(array('form'));
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->view('page/file_manager.html');
	}
	/**
	 * 上传图片
	 *
	 */
	public function upload()
	{
		
        $file = $_FILES['file'];//得到传输的数据
		//得到文件名称
		$name = $file['name'];
		$type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
		$allow_type = array('jpg','jpeg','gif','png'); //定义允许上传的类型
		//判断文件类型是否被允许上传
		if(!in_array($type, $allow_type)){
		  //如果不被允许，则直接停止程序运行
			echo '{"code": 1,"msg": "文件上传失败","data": {}}   ' ;
		  return ;
		}
		//判断是否是通过HTTP POST上传的
		if(!is_uploaded_file($file['tmp_name'])){
		  //如果不是通过HTTP POST上传的
			echo '{"code": 1,"msg": "文件上传失败","data": {}}   ' ;
		  return ;
		}
		$path = $this->input->get_post("path",true);
		if(empty($path)){
			$path=date("Y-m-d")."/";
		}
		$upload_path = "./images/".intval($_SESSION['b_uid'])."/".$path; 
		is_dir($upload_path) OR mkdir($upload_path, 0777, true); 
		$this->load->library('fun');
		$unique_rand = uniqid();
		$file_name = time().$unique_rand.'.'.$type;
		$url_path = "/images/".intval($_SESSION['b_uid'])."/".$path.$file_name;
		//开始移动文件到相应的文件夹
		if(move_uploaded_file($file['tmp_name'],$upload_path.$file_name)){
		  echo '{"code": 0,"msg": "文件上传成功","data": {"src":"'.$url_path .'"}}   ' ;
		}else{
		  echo '{"code": 1,"msg": "文件上传失败","data": {}}   ' ;
		}
        
		
	}
	/**
	 * 登录页面
	 *
	 */
	public function home()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$data["nickname"] =$this->session->userdata('nickname');
		$this->load->view('page/home.html',$data);
	}
	/**
	 * 登录页面
	 *
	 */
	public function login()
	{
		$newdata = array(
			'b_uid'  ,
			'username',
			'nickname',
			'type',
			'login'
		);
		$this->session->unset_userdata($newdata);
		$this->load->view('page/login.html');
	}
	/**
	 * 登录验证
	 *
	 */
	public function loginCheck()
	{
		$this->load->model('Users_business_model');
		$username=$this->input->post('username', TRUE);
		$pwd=$this->input->post('password', TRUE);
		$result = $this->Users_business_model->get_data($username);
		$data=array();
		if(empty($result)){
			$data['code']=0;
			$data['msg']="用户名不正确！";
			print_r(json_encode($data));
			exit();
		}
		$userinfo = $result[0];
		$pwd ='phpshop'.$pwd;
		if($userinfo->pwd!=md5($pwd)){
			$data['code']=0;
			$data['msg']="密码不正确！";
			print_r(json_encode($data));
			exit();
		}
		
		$newdata = array(
			'b_uid'  => $userinfo->b_uid,
			'username'     => $userinfo->username,
			'nickname'     => $userinfo->nickname,
			'type'     => $userinfo->type,
			'login' => TRUE
		);

		$this->session->set_userdata($newdata);
		$data['code']=1;
		$data['msg']="登录成功";
		
		print_r(json_encode($data));
	}
	
	/**
	 * 商品分类
	 *
	 */
	public function category()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$data = json_decode(file_get_contents( site_url('Json/category')),1);
		$this->load->view('common/head.html');
		$this->load->view('page/category.html',$data);
	}
	
	/**
	 * 商品选项
	 *
	 */
	public function goods_select()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->view('common/head.html');
		$this->load->view('page/goods_select.html');
	}
	/**
	 * 商品属性组
	 *
	 */
	public function goods_attribute()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->view('common/head.html');
		$this->load->view('page/goods_attribute.html');
	}
	/**
	 * 商品属性
	 *
	 */
	public function goods_attribute_option()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->view('common/head.html');
		$this->load->view('page/goods_attribute_option.html');
	}
	/**
	 * 商品品牌
	 *
	 */
	public function brand()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->view('common/head.html');
		$this->load->view('page/brand.html');
	}
	/**
	 * 商品
	 *
	 */
	public function goods()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->view('common/head.html');
		$this->load->view('page/goods.html');
	}

	/**
	 * 添加/修改商品
	 *
	 */
	public function goods_action()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->view('common/head.html');
		$this->load->view('page/goods_action.html');
	}
	/**
	 * 添加/修改商品
	 *
	 */
	public function pwd()
	{
		echo md5('phpshop123456');
	}
	
	
}
