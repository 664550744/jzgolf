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

    /**
     * Notes: 删除购物车中的商品
     * User: wangwenhua
     * Date: 2018/8/30
     * Time: 下午8:21
     * qq: 664550744
     * e-mail:664550744@qq.com
     */
    public function deleteCart()
    {
        $this->load->library('login');
        $this->load->library('common');
        $login_ok = $this->login->login_ok();
        if (!$login_ok) {
            $this->common->json(array('code' => 0, 'msg' => '请先登录'));
        }
       $id = intval($this->input->get_post("id",true));
        $this->load->model('Cart_model');
        $r = $this->Cart_model->delete($id);
        if($r){
            $this->common->json(array('code' => 1, 'msg'=>'购物车商品删除成功'));
        }else{
            $this->common->json(array('code' => 0, 'msg'=>'购物车商品删除失败'));
        }
    }

    public function numCart(){
        $this->load->library('login');
        $this->load->library('common');
        $login_ok = $this->login->login_ok();
        if (!$login_ok) {
            $this->common->json(array('code' => 0, 'msg' => '请先登录'));
        }
        $id = intval($this->input->get_post("id",true));
        $num = intval($this->input->get_post("num",true));
        $this->load->model('Cart_model');
        $r = $this->Cart_model->update(array('num'=>$num),$id);
        if($r){
            $this->common->json(array('code' => 1, 'msg'=>'购物车商品数量修改成功'));
        }else{
            $this->common->json(array('code' => 0, 'msg'=>'购物车商品数量修改失败'));
        }

    }

    /**
     * Notes:添加收货地址
     * User: wangwenhua
     * Date: 2018/8/31
     * Time: 下午1:38
     * qq: 664550744
     * e-mail:664550744@qq.com
     */
    public function addAddress(){
        $this->load->library('login');
        $this->load->library('common');
        $login_ok = $this->login->login_ok();
        if (!$login_ok) {
            $this->common->json(array('code' => 0, 'msg' => '请先登录'));
        }
        $this->load->model('Address_model');
        $data  = array();
        $data["u_id"] = $this->session->userdata('user_id');
        $data["name "] =$this->input->get_post("name",true);
        $data["tel "] =$this->input->get_post("tel",true);
        $data["city "] =$this->input->get_post("city",true);
        $data["address "] =$this->input->get_post("address",true);

        $r = $this->Address_model->insert($data);
        if($r){
            $this->common->json(array('code' => 1, 'msg'=>'收货地址添加成功','redirect_url'=>$this->session->userdata('redirect_url')));
        }else{
            $this->common->json(array('code' => 0, 'msg'=>'添加购物车失败'));
        }

    }

    /**
     * Notes:生成订单并清空购物车
     * User: wangwenhua
     * Date: 2018/9/5
     * Time: 下午3:34
     * qq: 664550744
     * e-mail:664550744@qq.com
     */
    public function addOrder(){
        $this->load->library('login');
        $this->load->library('common');
        $login_ok = $this->login->login_ok();
        if (!$login_ok) {
            $this->common->json(array('code' => 0, 'msg' => '请先登录'));
        }
        $u_id = $this->session->userdata('user_id');

        $this->load->model('Cart_model');
        $r = $this->Cart_model->getGoods($u_id);
        if(empty($r)){
            $this->common->json(array('code' => 0, 'msg' => '购物车商品已经没有了'));
        }
        $goods=array();
        $stock_num_info=array();
        $num =$this->input->get_post("num",true);
        $out_trade_no=$this->common->order_number();
        $b_id=$r[0]["b_id"];
        $orders=array();
        $total_fee=0;
        for ($i=0;$i<count($r);$i++){

            if($r[$i]["stock_num"]<$r[$i]["num"]){
                $this->common->json(array('code' => 100, 'msg' => '很抱歉，库存不足了...'));
            }
            $total_fee+=$r[$i]["price"]*$r[$i]["num"];
            $goods[]=array('o_num'=>$out_trade_no,'g_id'=>$r[$i]["g_id"],'num'=>$r[$i]["num"],'price'=>$r[$i]["price"],'goods_selects'=>$r[$i]["goods_selects"],'goods_selects_text'=>$r[$i]["goods_selects_text"]);
            $stock_num_info[]=$r[$i]["stock_num_info"];
            if($b_id!=$r[$i]["b_id"]){
                $orders[]=array('p_num'=>$num,'num'=>$out_trade_no,'total_fee'=>$total_fee,'user_id'=>$u_id,'b_id'=>$b_id);
                $out_trade_no=$this->common->order_number();
                $b_id=$r[$i]["b_id"];
                $total_fee=0;

            }



        }
        $orders[]=array('p_num'=>$num,'num'=>$out_trade_no,'total_fee'=>$total_fee,'user_id'=>$u_id,'b_id'=>$b_id);
        $this->load->model('Order_table_model');
        $insert = $this->Order_table_model->insert($orders,$goods,$u_id,$stock_num_info);
        if($insert==1){
            $this->common->json(array('code' => 1, 'msg' => '订单创建成功'));
        }else{
            $this->common->json(array('code' => 0, 'msg' => '订单创建失败'));
        }

    }
}