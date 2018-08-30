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
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
		
		$userSess = array(
				'user_id'  => "55",
				'token_id'   => "690b8965ec924ea578511567de573038",
				'alias'     => ".",
				'photo'     => "http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKgymXKcicqZe2Vhwmt4RE5JcLNnxeX685ZGDrkJ5AOYjT7rq7FHwJibKV7hE8luoqWI5QaxyyibxUUQ/132",
				'ID'     => "96905",
				'login' => TRUE
			);

		$this->session->set_userdata($userSess);
		
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->model('Cart_model');
		$num = $this->Cart_model->getNum($this->session->userdata('user_id'));
		$this->load->view('header.html');
		$this->load->view('welcome_message');
		$this->load->view('footer.html',array('menuAct' => 0,'num'=>$num));
	}
	public function category()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->model('Cart_model');
		$num = $this->Cart_model->getNum($this->session->userdata('user_id'));
		$this->load->view('header.html');
		$this->load->view('category');
		$this->load->view('footer.html',array('menuAct' => 1,'num'=>$num));
	}
	public function cart()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->model('Cart_model');
		$r = $this->Cart_model->getData($this->session->userdata('user_id'));
		$num = $this->Cart_model->getNum($this->session->userdata('user_id'));

		$this->load->view('header.html');
		$this->load->view('cart',array('dataList'=>$r));
		$this->load->view('footer.html',array('menuAct' => 2,'num'=>$num));
	}
	public function user()
	{
		$this->load->library('login');
		$this->login->isLogin();  
		$this->load->model('Cart_model');
		$num = $this->Cart_model->getNum($this->session->userdata('user_id'));
		$this->load->view('header.html');
		$this->load->view('user');
		$this->load->view('footer.html',array('menuAct' => 3,'num'=>$num));
	}

	public function categoryGoods()
	{
		$this->load->library('login');
		$this->login->isLogin();  
		$this->load->model('Cart_model');
		$num = $this->Cart_model->getNum($this->session->userdata('user_id'));
		
		$cat = intval($this->uri->segment(3));
		$title = array('一号木','球道木','铁杆','推杆','穿戴','配件','套杆','二手区');
		$this->load->view('header.html');
		$this->load->view('category_goods',array('title' => $title[$cat],'cat'=>$cat ));
		$this->load->view('footer.html',array('num'=>$num));
	}

	public function checkOrder(){
        $this->load->view('header.html');
        $this->load->view('checkOrder',array('title' => '确认订单' ));


    }
	
	
	
}
