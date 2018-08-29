<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	
	
	/**
	 * 商品分类 添加--修改
	 *
	 */
	public function category()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		$this->load->model('Category_model');
		$data = array();
		$data["text"] = $this->input->get_post("text",true);
		if(empty($data["text"])){
			print_r(json_encode(array('code'=>0,'msg'=>'分类名称不能为空！')));
			exit();
		}
		$data["pid"] = intval($this->input->get_post("pid",true));
		$data["order"] = intval($this->input->get_post("order",true));
		$r=array();
		if( intval($this->input->get_post("id",true))==0){
			
			$r= $this->Category_model->add($data);
		}else{
			$r=$this->Category_model->update($data,array('id'=>intval($this->input->get_post("id",true))));
		}
		
		if(!empty($r)){
			print_r(json_encode($r));
		}else{
			print_r(json_encode(array('code'=>0,'msg'=>'未知结果！')));
		}
	}
	/**
	 * 商品分类 删除
	 *
	 */
	public function categoryDel()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		$this->load->model('Category_model');
		$r= $this->Category_model->del(intval($this->input->get_post("id",true)));
		if($r){
			print_r(json_encode(array('code'=>1,'msg'=>'删除成功！')));
		}else{
			print_r(json_encode(array('code'=>0,'msg'=>'删除失败！')));
		}
		
	}
	/**
	 * 商品分类 状态修改
	 *
	 */
	public function categoryState()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		$this->load->model('Category_model');
		$data = array();
		$data['state'] =intval($this->input->get_post("state",true));
		$r=$this->Category_model->update($data,array('id'=>intval($this->input->get_post("id",true))));
		if(!empty($r)){
			print_r(json_encode($r));
		}else{
			print_r(json_encode(array('code'=>0,'msg'=>'未知结果！')));
		}
		
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
		$data = array(); 
		$data["type"] = intval($this->input->get_post("type",true));
		$data["order_value"] = intval($this->input->get_post("order_value",true));
		$data["text"] = $this->input->get_post("text",true);
		$data["b_uid"] = intval($_SESSION['b_uid']);
		$options = array(); 
		if($this->input->get_post("options")){
			$optionsArr = $this->input->get_post("options");
			$options_imgArr = $this->input->get_post("options_img");
			$options_orderArr = $this->input->get_post("options_order");
			for($i=0;$i<count($optionsArr);$i++){
				$options[]=array("option"=>$optionsArr[$i],"options_img"=>$options_imgArr[$i],"options_order"=>$options_orderArr[$i]);
			}
			
		}
		$data["options"] = json_encode($options);
		if( intval($this->input->get_post("id",true))==0){
			
			$r= $this->Goods_select_model->add($data);
		}else{
			$r=$this->Goods_select_model->update($data,array('id'=>intval($this->input->get_post("id",true))));
		}
		if(!empty($r)){
			print_r(json_encode($r));
		}else{
			print_r(json_encode(array('code'=>0,'msg'=>'未知结果！')));
		}
		
	}
	
	
	/**
	 * 商品选项 删除
	 *
	 */
	public function goodsSelectDel()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		$this->load->model('Goods_select_model');
		$r= $this->Goods_select_model->del(intval($this->input->get_post("id",true)));
		if($r){
			print_r(json_encode(array('code'=>1,'msg'=>'删除成功！')));
		}else{
			print_r(json_encode(array('code'=>0,'msg'=>'删除失败！')));
		}
		
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
		$data = array(); 
		$data["order_value"] = intval($this->input->get_post("order_value",true));
		$data["text"] = $this->input->get_post("text",true);
		$data["b_uid"] = intval($_SESSION['b_uid']);
		
		if( intval($this->input->get_post("id",true))==0){
			
			$r= $this->Goods_attribute_model->add($data);
		}else{
			$r=$this->Goods_attribute_model->update($data,array('id'=>intval($this->input->get_post("id",true))));
		}
		if(!empty($r)){
			print_r(json_encode($r));
		}else{
			print_r(json_encode(array('code'=>0,'msg'=>'未知结果！')));
		}
		
	}
	
	/**
	 * 商品属性组 删除
	 *
	 */
	public function goodsAttributeDel()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		$this->load->model('Goods_attribute_model');
		$r= $this->Goods_attribute_model->del(intval($this->input->get_post("id",true)));
		if($r){
			print_r(json_encode(array('code'=>1,'msg'=>'删除成功！')));
		}else{
			print_r(json_encode(array('code'=>0,'msg'=>'删除失败！')));
		}
		
	}
	
	/**
	 * 商品属性组
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
		$data = array(); 
		$data["order_value"] = intval($this->input->get_post("order_value",true));
		$data["pid"] = intval($this->input->get_post("pid",true));
		$data["text"] = $this->input->get_post("text",true);
		
		
		if( intval($this->input->get_post("id",true))==0){
			
			$r= $this->Goods_attribute_option_model->add($data);
		}else{
			$r=$this->Goods_attribute_option_model->update($data,array('id'=>intval($this->input->get_post("id",true))));
		}
		if(!empty($r)){
			print_r(json_encode($r));
		}else{
			print_r(json_encode(array('code'=>0,'msg'=>'未知结果！')));
		}
		
	}
	
	/**
	 * 商品属性组 删除
	 *
	 */
	public function goodsAttributeOptionDel()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		$this->load->model('Goods_attribute_option_model');
		$r= $this->Goods_attribute_option_model->del(intval($this->input->get_post("id",true)));
		if($r){
			print_r(json_encode(array('code'=>1,'msg'=>'删除成功！')));
		}else{
			print_r(json_encode(array('code'=>0,'msg'=>'删除失败！')));
		}
		
	}


	
	/**
	 * 商品品牌
	 *
	 */
	public function goods_brand()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		
		$this->load->model('Goods_brand_model');
		$data = array(); 
		$data["order_value"] = intval($this->input->get_post("order_value",true));
		$data["text"] = $this->input->get_post("text",true);
		
		
		if( intval($this->input->get_post("id",true))==0){
			
			$r= $this->Goods_brand_model->add($data);
		}else{
			$r=$this->Goods_brand_model->update($data,array('id'=>intval($this->input->get_post("id",true))));
		}
		if(!empty($r)){
			print_r(json_encode($r));
		}else{
			print_r(json_encode(array('code'=>0,'msg'=>'未知结果！')));
		}
		
	}
	
	/**
	 * 商品品牌 删除
	 *
	 */
	public function goodsBrandDel()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		$this->load->model('Goods_brand_model');
		$r= $this->Goods_brand_model->del(intval($this->input->get_post("id",true)));
		if($r){
			print_r(json_encode(array('code'=>1,'msg'=>'删除成功！')));
		}else{
			print_r(json_encode(array('code'=>0,'msg'=>'删除失败！')));
		}
		
	}
	
	/**
	 * 商品添加/修改 
	 *
	 */
	public function goods()
	{
		$this->load->library('login');
		
		if($this->login->isLoginAjax()){
			print_r(json_encode(array('code'=>101,'msg'=>'登录超时！')));
			exit();
		}
		
		$imgs= json_decode($this->input->get_post("imgs",true),1);
		$stock_num_info= json_decode($this->input->get_post("stock_num_info",true),1);
		$stock_num =$this->input->get_post("stock_num",true) ;
		if(count($stock_num_info)>0){
			$stock_num =0;
			for($i=0;$i<count($stock_num_info);$i++){
				$stock_num +=intval($stock_num_info[$i]['v']);
			}
		}
		

		$data = array(
			'name' => $this->input->get_post("name",true) ,
			'b_uid' =>$this->session->userdata('b_uid'),
			'price_market' => $this->input->get_post("price_market",true) , 
			'price' => $this->input->get_post("price",true) , 
			'online' => $this->input->get_post("online",true) , 
			'is_new' => $this->input->get_post("is_new",true) , 
			'num_code' => $this->input->get_post("num_code",true) , 
			'stock_num' => $stock_num , 
			'stock_num_info' => $this->input->get_post("stock_num_info",true) , 
			'category_id' => intval($this->input->get_post("category_id")) , 
			'brand_id' => intval($this->input->get_post("brand_id")) , 
		);
		$detail = array(
			'imgs' => $this->input->get_post("imgs",true), 
			'goods_attribute' => $this->input->get_post("goods_attribute",true), 
			'goods_select' => $this->input->get_post("goods_select",true), 
			'goods_content' => $this->input->get_post("content",true), 
		);
		$this->load->model('goods_model');
		$id = intval($this->input->get_post("id",true));
		if($id==0){
			$r=$this->goods_model->add($data,$detail);
			if($r['code']==0){
				print_r(json_encode($r));
				exit();
			}
			$id =$r['id'];
		}else{
			$this->goods_model->update($data,$id,$detail);
		}
		

		$p =$imgs[0];
		$path ="../public".$p;
		
		$config['image_library'] = 'gd2';
	    $config['source_image'] = $path;
	    $config['create_thumb'] = TRUE;
	    //生成的缩略图将在保持纵横比例 在宽度和高度上接近所设定的width和height
	    $config['maintain_ratio'] = TRUE;
	    $config['width'] = 240;
	    $config['height'] = 240;
	    $this->load->library('image_lib', $config);
	    $this->image_lib->resize();
	    
	    $oldFilePath = explode("/",$path);
	    $oldFile =$oldFilePath[count($oldFilePath)-1];

	    $sve_pathAA=explode($oldFile,$path);
	    $sve_path= $sve_pathAA[0];
	    $url_pathAA=explode($oldFile,$p);
	    $url_path= $url_pathAA[0];
	    $oldFileAA=explode(".",$oldFile);
	    $old_file_name=$oldFileAA[0];
	    $old_file_type=$oldFileAA[1];

	    rename($sve_path.$old_file_name."_thumb.".$old_file_type,$sve_path.$id.".".$old_file_type);
	    $img_url = $url_path.$id.".".$old_file_type;
	    $this->goods_model->img(array('img' =>$img_url ),array('id' => $id));
	    print_r(json_encode(array('code'=>1,'msg'=>'操作成功')));
		
		
	}
	
}
