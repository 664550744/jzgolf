<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends CI_Controller {
	//首页 商品
	public function index()
	{
		$this->load->library('login');
		$this->login->isLogin();  

		$this->load->model('Goods_model');
		$num=intval($this->input->get_post("pagesize",true));
		$page=intval($this->input->get_post("page",true))-1;
		$result= $this->Goods_model->get_json_list($num,$page);
		//echo'(';
		print_r(json_encode($result));
		//echo')';
	}

	public function categoryGoods()
	{
		$this->load->library('login');
		$this->login->isLogin();  

		$this->load->model('Goods_model');
		$num=intval($this->input->get_post("pagesize",true));
		$page=intval($this->input->get_post("page",true))-1;
		$type=intval($this->input->get_post("type",true));
		$where = array();
		switch ($type) {
			case 0:
				# 一号木
				$where = array('category_id'=>30);
				break;
			case 1:
				# 球道木
				$where = array('category_id'=>31);

				break;
			case 2:
				# 铁杆
				$where = array('category_id'=>34);

				break;
			case 3:
				# 推杆
				$where = array('category_id'=>33);

				break;
			case 4:
				# 穿戴
				$where = array('category_id'=>35);

				break;
			case 5:
				# 配件
				$where = array('category_id'=>36);
				break;
			case 6:
				# 套杆
				$where = array('category_id'=>32);

				break;
			case 7:
				# 二手区
				$where = array('is_new'=>1);

				break;
			
			default:
				# code...
				exit();
				break;
		}

		$result= $this->Goods_model->get_json_list($num,$page,$where);

		//echo'(';
		print_r(json_encode($result));
		//echo')';
	}
	public function category()
	{
		$this->load->library('login');
		$this->login->isLogin();  

		$this->load->model('Goods_model');
		$num=10;
		$page=0;
		
		$where = array();
		$data  = array();

			# 一号木
			$where = array('category_id'=>30);
			$data[] = $this->Goods_model->get_json_list($num,$page,$where);
			# 球道木
			$where = array('category_id'=>31);
			$data[] = $this->Goods_model->get_json_list($num,$page,$where);
			# 铁杆
			$where = array('category_id'=>34);
			$data[] = $this->Goods_model->get_json_list($num,$page,$where);
			# 推杆
			$where = array('category_id'=>33);
			$data[] = $this->Goods_model->get_json_list($num,$page,$where);
			# 穿戴
			$where = array('category_id'=>35);
			$data[] = $this->Goods_model->get_json_list($num,$page,$where);
			# 配件
			$where = array('category_id'=>36);
			$data[] = $this->Goods_model->get_json_list($num,$page,$where);
			# 套杆
			$where = array('category_id'=>32);
			$data[] = $this->Goods_model->get_json_list($num,$page,$where);
			# 二手区
			$where = array('is_new'=>1);
			$data[] = $this->Goods_model->get_json_list($num,$page,$where);
			
			print_r(json_encode($data));
	}

	public function goodsDetail(){
		$this->load->library('login');
		$this->login->isLogin();  
		
		$id = intval($this->uri->segment(3));
		$this->load->model('Goods_model');
		$goods = $this->Goods_model->get_goods($id);
		//print_r(json_encode($goods)); 
		//$this->load->view('header.html');
		$this->load->view('goods',$goods);
		
	}
	public function content(){
		$id = intval($this->uri->segment(3));
		$this->load->model('Goods_model');
		$goods = $this->Goods_model->get_content($id);
		$html = str_replace("img src=","img src='/assets/img/goods_default.jpg' style='width:100%;' data-url=",$goods);
		print_r($html); 
		
		
	}

	
}