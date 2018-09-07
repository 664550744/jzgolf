<?php

class Cart_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function getData($u_id)
    {

        $this->db->select("c.id,c.g_id,c.num,c.price,c.goods_selects,c.goods_selects_text,goods.name,goods.img,goods.stock_num,goods.stock_num_info");
    	$this->db->where("u_id",$u_id);
        $this->db->from('cart as c');
        $this->db->join('goods', 'goods.id = c.g_id');
 
        $query = $this->db->get();
		//$query = $this->db->get("cart");
		$result = array();
		foreach ($query->result() as $row)
		{
		    $stock_num_info = json_decode($row->stock_num_info,1);
            $goods_selects = json_decode($row->goods_selects,1);

            for($i=0;$i<count($stock_num_info);$i++){
                switch (count($goods_selects))
                {
                    case 1:
                       if($goods_selects[0]==$stock_num_info[$i]["k"][0]) {
                           $row->stock_num = $stock_num_info[$i]["v"];
                       }
                        break;
                    case 2:
                        if($goods_selects[0]==$stock_num_info[$i]["k"][0]&&$goods_selects[1]==$stock_num_info[$i]["k"][1]) {
                            $row->stock_num = $stock_num_info[$i]["v"];
                        }
                        break;
                    case 3:
                        if($goods_selects[0]==$stock_num_info[$i]["k"][0]&&$goods_selects[1]==$stock_num_info[$i]["k"][1]&&$goods_selects[2]==$stock_num_info[$i]["k"][2]) {
                            $row->stock_num = $stock_num_info[$i]["v"];
                        }
                        break;

                }

            }

			$result[] = array('id' => $row->id,'g_id' => $row->g_id,'name' => $row->name,'img' => $row->img,'num' => $row->num,'price' => $row->price,'goods_selects' => $row->goods_selects,'goods_selects_text' => $row->goods_selects_text ,'stock_num' => $row->stock_num );
		    
		}
		return $result;
    }

    /**
     * Notes: 获取购物车的商品数量
     * User: wangwenhua
     * Date: 2018/8/29
     * Time: 上午11:49
     * qq: 664550744
     * e-mail:664550744@qq.com
     * @param $u_id
     * @return int
     */
    public function getNum($u_id)
    {
        $this->db->select("SUM(num) as num");
        $this->db->where("u_id",$u_id);
        $query = $this->db->get("cart");
        $num = 0;
        foreach ($query->result() as $row)
        {
            $num =  $row->num; 
            
        }
        return $num;

    }

    public function insert($data)
    {
    	$r= $this->db->insert('cart', $data);
    	return $r;
    }
    public function update($data,$id)
    {
    	
		$this->db->where('id', $id);
		$r = $this->db->update('cart',$data);
		return $r;

    }
    public function delete($id)
    {

        $this->db->where('id', $id);
        return $this->db->delete('cart');
    }
    public function getGoods($u_id)
    {


        $this->db->select("c.id,c.g_id,c.num,c.price,c.goods_selects,c.goods_selects_text,goods.name,goods.img,goods.stock_num,goods.b_uid as b_id,goods.stock_num_info");
        $this->db->where("u_id",$u_id);
        $this->db->from('cart as c');
        $this->db->join('goods', 'goods.id = c.g_id');
        $this->db->order_by("goods.b_uid", "desc");

        $query = $this->db->get();

        $result = array();
        foreach ($query->result() as $row)
        {
            $stock_num_info = json_decode($row->stock_num_info,1);
            $goods_selects = json_decode($row->goods_selects,1);

            for($i=0;$i<count($stock_num_info);$i++){
                switch (count($goods_selects))
                {
                    case 1:
                        if($goods_selects[0]==$stock_num_info[$i]["k"][0]) {
                            $row->stock_num = $stock_num_info[$i]["v"];
                        }
                        break;
                    case 2:
                        if($goods_selects[0]==$stock_num_info[$i]["k"][0]&&$goods_selects[1]==$stock_num_info[$i]["k"][1]) {
                            $row->stock_num = $stock_num_info[$i]["v"];
                        }
                        break;
                    case 3:
                        if($goods_selects[0]==$stock_num_info[$i]["k"][0]&&$goods_selects[1]==$stock_num_info[$i]["k"][1]&&$goods_selects[2]==$stock_num_info[$i]["k"][2]) {
                            $row->stock_num = $stock_num_info[$i]["v"];
                        }
                        break;

                }

            }
            $result[] = array('g_id' => $row->g_id,'b_id' => $row->b_id,'num' => $row->num,'price' => $row->price,'goods_selects' => $row->goods_selects,'goods_selects_text' => $row->goods_selects_text,'stock_num' => $row->stock_num,'stock_num_info'=> $row->stock_num_info);

        }
        return $result;
    }
}