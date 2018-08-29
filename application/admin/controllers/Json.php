<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {

	
	
	/**
	 * 商品分类
	 *
	 */
	public function category()
	{
		
		$this->load->library('fun');
	
		$this->load->model('Category_model');
		$result = $this->Category_model->get_data();
		$data=array();
		foreach ($result as $row)
		{
			$data[]=array('id'=>$row->id,'pid'=>$row->pid,'text'=>$row->text,'order'=>$row->order,'state'=>$row->state);
		}
		$num = count($data);
		$data = $this->fun->tree($data);
		$result = array();
		for($i=0;$i<count($data);$i++){
			$mum=0;
			if(isset($data[$i]['children'])){
				$mum=count($data[$i]['children']);
			}
			$result[]=array('id'=>$data[$i]['id'],'pid'=>$data[$i]['pid'],'text'=>$data[$i]['text'],'order'=>$data[$i]['order'],'state'=>$data[$i]['state'],'type'=>0,'children'=>$mum);
			if(isset($data[$i]['children'])){
				for($j=0;$j<count($data[$i]['children']);$j++){
					$mum=0;
					if(isset($data[$i]['children'][$j]['children'])){
						$mum=count($data[$i]['children'][$j]['children']);
					}
					$result[]=array('id'=>$data[$i]['children'][$j]['id'],'pid'=>$data[$i]['children'][$j]['pid'],'text'=>$data[$i]['children'][$j]['text'],'order'=>$data[$i]['children'][$j]['order'],'state'=>$data[$i]['children'][$j]['state'],'type'=>1,'children'=>$mum);
					if(isset($data[$i]['children'][$j]['children'])){
						for($k=0;$k<count($data[$i]['children'][$j]['children']);$k++){
							$result[]=array('id'=>$data[$i]['children'][$j]['children'][$k]['id'],'pid'=>$data[$i]['children'][$j]['children'][$k]['pid'],'text'=>$data[$i]['children'][$j]['children'][$k]['text'],'order'=>$data[$i]['children'][$j]['children'][$k]['order'],'state'=>$data[$i]['children'][$j]['children'][$k]['state'],'type'=>2,'children'=>0);
						}
					}
				}
			}
			
		}
		print_r(json_encode(array('code'=>1,'data'=>$result,'num'=>$num)));
	}
	
	/**
	 * 商品选项
	 *
	 */
	public function goods_select()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		
		$this->load->model('Goods_select_model');
		$result= $this->Goods_select_model->get_data(array("b_uid"=>intval($_SESSION['b_uid'])));
		$data=array();
		foreach ($result as $row)
		{
			$data[]=array('id'=>$row->id,'b_uid'=>$row->b_uid,'text'=>$row->text,'type'=>$row->type,'order_value'=>$row->order_value,'options'=>$row->options);
		}
		print_r(json_encode(array('code'=>1,'data'=>$data)));
		
	}
	/**
	 * 商品属性组
	 *
	 */
	public function goods_attribute()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		
		$this->load->model('Goods_attribute_model');
		$result= $this->Goods_attribute_model->get_data(array("b_uid"=>intval($_SESSION['b_uid'])));
		$data=array();
		foreach ($result as $row)
		{
			$data[]=array('id'=>$row->id,'b_uid'=>$row->b_uid,'text'=>$row->text,'order_value'=>$row->order_value);
		}
		print_r(json_encode(array('code'=>1,'data'=>$data)));
		
	}
	/**
	 * 商品属性
	 *
	 */
	public function goods_attribute_option()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		
		$this->load->model('Goods_attribute_option_model');
		$result= $this->Goods_attribute_option_model->get_data(intval($_SESSION['b_uid']));
		$data=array();
		foreach ($result as $row)
		{
			$data[]=array('id'=>$row->id,'pid'=>$row->pid,'text'=>$row->text,'p_text'=>$row->p_text,'order_value'=>$row->order_value);
		}
		print_r(json_encode(array('code'=>1,'data'=>$data)));
		
	}
	/**
	 * 图片管理
	 *
	 */
	public function fileManageer()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		$this->load->helper('directory');
		$path = "./images/".$_SESSION['b_uid'];
		if(!file_exists($path))
		{
			mkdir($path,0777);
			
		}
		$path = $path.$this->input->get_post("path",true);
		$map = directory_map($path,1);
		$data = array();
		for($i=0;$i<count($map);$i++){
			if(strpos($map[$i],'\\') !==false){
				$data[]= array('type'=>1,'name'=>str_replace("\\","",$map[$i]));
			}else if(strpos($map[$i],'/') !==false){
				$data[]= array('type'=>1,'name'=>str_replace("/","",$map[$i]));
			}else{
				$data[]= array('type'=>0,'name'=>$map[$i]);
			}
		}
		for($i=0;$i<count($data)-1;$i++){
			for($j=0;$j<count($data);$j++){
				if($data[$i]["type"]>$data[$j]["type"]){
					$temp = $data[$i];
					 $data[$i] = $data[$j];
					 $data[$j] = $temp;
				}
			}
			
		}
		print_r(json_encode(array('code' =>1 ,'data'=>$data,'path'=>"images/".$_SESSION['b_uid'].'/' )));
		
	}

	/**
	 * 商品品牌
	 *
	 */
	public function goods_brand()
	{
		
		
		$this->load->model('Goods_brand_model');
		//$result= $this->Goods_brand_model->get_data();
		$result= $this->Goods_brand_model->get_data($arrayName = array('id >' => 0));
		$data=array();
		foreach ($result as $row)
		{
			$data[]=array('id'=>$row->id,'text'=>$row->text,'order_value'=>$row->order_value);
		}
		print_r(json_encode(array('code'=>1,'data'=>$data)));
		
	}

	/**
	 * 商品
	 *
	 */
	public function getGoods()
	{
		
		$category = json_decode(file_get_contents(site_url('Json/category')),1);
		$goods_brand = json_decode(file_get_contents(site_url('Json/goods_brand')),1);
		$data=array(
			'category'=>$category,
			'goods_brand'=>$goods_brand
		);
		$id = intval($this->input->get_post("id",true));
		$goods=array();
		if($id>0){
			$this->load->model('Goods_model');
			$goods= $this->Goods_model->get_data($id);
		}
		
		print_r(json_encode(array('code'=>1,'data'=>$data,'goods'=>$goods)));
		
	}

	/**
	 * 商品列表
	 *
	 */
	public function goodsList()
	{
		
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		$this->load->model('Goods_model');
		$b_uid = $this->session->userdata('b_uid');
		$num = $this->input->get_post("limit",true)?intval($this->input->get_post("limit",true)):10;
		$page = $this->input->get_post("page",true)?intval($this->input->get_post("page",true))-1:0;
		$result= $this->Goods_model->get_json_list($b_uid,$num,$page);
		print_r(json_encode(array('code'=>0,'count'=>$result['count_all'],'msg'=>'','data'=>$result['data'])));
		
	}
}
