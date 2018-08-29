<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

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
	 * @return [type:json] [description:添加商品到购物车]
	 */
	public function addcart(){
		$this->load->library('login');
		$this->load->library('common');
		$login_ok = $this->login->login_ok();  
		if(!$login_ok){
			$this->common->json(array('code' => 0, 'msg'=>'请先登录'));
		}
		$data  = array();
		$data["u_id"] = $this->session->userdata('user_id');
		$data["g_id"] = intval($this->input->get_post("g_id",true));
		$data["goods_selects"] = $this->input->get_post("goods_selects",true);
		$data["goods_selects_text"] = $this->input->get_post("goods_selects_text",true);
		$data["price"] = $this->input->get_post("price",true);
		//$data["name"] = $this->input->get_post("name",true);


		
		

		//print_r(json_encode($_POST));
		$this->load->model('Cart_model');

		$r = $this->Cart_model->getData($this->session->userdata('user_id'));
		$isHasCart = false;
		$id = 0;
		$num = 1;
		for($i=0;$i<count($r);$i++){
			if(intval($this->input->get_post("g_id",true))==intval($r[$i]["g_id"])&&$this->input->get_post("goods_selects_text",true)==$r[$i]["goods_selects_text"]){

				$id = intval($r[$i]["id"]);
				$num = intval($r[$i]["num"])+1;
				$isHasCart = true;
				break;
			}
		}

		if($isHasCart){
			$r = $this->Cart_model->update(array('num'=>$num),$id);
		}else{
			$r = $this->Cart_model->insert($data);
		}
		if($r){
			$this->common->json(array('code' => 1, 'msg'=>'加入购物车成功'));
		}else{
			$this->common->json(array('code' => 0, 'msg'=>'添加购物车失败'));
		}
		
		
	}
}