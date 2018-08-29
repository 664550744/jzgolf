<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dialog extends CI_Controller {

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
	 
	
	
	/**
	 * 商品分类
	 *
	 */
	public function category()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$category = json_decode(file_get_contents( site_url('Data/category')),1);
		$data = array();
		$data["data"] = $category["data"];
		$data["text"] = $this->input->get_post("text",true);
		$data["id"] = intval($this->input->get_post("id",true));
		$data["pid"] = intval($this->input->get_post("pid",true));
		$data["order"] = intval($this->input->get_post("order",true));
		$this->load->view('common/head.html');
		$this->load->view('dialog/category.html',$data);
	}
	/**
	 * 商品选项
	 *
	 */
	public function goods_select()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->model('Goods_select_model');
		$result= $this->Goods_select_model->get_data(array("id"=>intval($this->input->get_post("id",true))));
		$data=$data=array('id'=>0,'text'=>'','type'=>'','order_value'=>0,'options'=>'null');
		foreach ($result as $row)
		{
			$data=array('id'=>$row->id,'text'=>$row->text,'type'=>$row->type,'order_value'=>$row->order_value,'options'=>$row->options);
		}
		
		$this->load->view('common/head.html');
		$this->load->view('dialog/goods_select.html',$data);
	}
	/**
	 * 商品属性组
	 *
	 */
	public function goods_attribute()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->model('Goods_attribute_model');
		$result= $this->Goods_attribute_model->get_data(array("id"=>intval($this->input->get_post("id",true))));
		$data=$data=array('id'=>0,'text'=>'','type'=>'','order_value'=>0,'options'=>'null');
		foreach ($result as $row)
		{
			$data=array('id'=>$row->id,'text'=>$row->text,'order_value'=>$row->order_value);
		}
		
		$this->load->view('common/head.html');
		$this->load->view('dialog/goods_attribute.html',$data);
	}
	/**
	 * 商品属性
	 *
	 */
	public function goods_attribute_option()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->model('Goods_attribute_option_model');
		$result= $this->Goods_attribute_option_model->get_data(intval($this->input->get_post("id",true)),1);
		$data=$data=array('id'=>0,'pid'=>0,'text'=>'','order_value'=>0);
		foreach ($result as $row)
		{
			$data=array('id'=>$row->id,'pid'=>$row->pid,'text'=>$row->text,'order_value'=>$row->order_value);
		}

		$this->load->model('Goods_attribute_model');
		$result= $this->Goods_attribute_model->get_data(array("b_uid"=>intval($_SESSION['b_uid'])));
		$attribute=array();
		foreach ($result as $row)
		{
			$attribute[]=array('id'=>$row->id,'text'=>$row->text);
		}
		$data["attribute"] = $attribute;
		$this->load->view('common/head.html');
		$this->load->view('dialog/goods_attribute_option.html',$data);
	}

	/**
	 * 商品属性
	 *
	 */
	public function goods_brand()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->model('Goods_brand_model');
		$result= $this->Goods_brand_model->get_data(array('id'=>intval($this->input->get_post("id",true))));
		$data=$data=array('id'=>0,'text'=>'','order_value'=>0);
		foreach ($result as $row)
		{
			$data=array('id'=>$row->id,'text'=>$row->text,'order_value'=>$row->order_value);
		}

		$this->load->view('common/head.html');
		$this->load->view('dialog/goods_brand.html',$data);
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
		$this->load->view('dialog/goods.html',array('id' => intval($this->input->get_post("id",true))));
	}
	
	/**
	 * 商品 选项设置
	 *
	 */
	public function goods_select_set()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->view('common/head.html');
		$this->load->view('dialog/goods_select_set.html');
	}
	
}
