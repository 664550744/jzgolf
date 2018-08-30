<?php

class Cart_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function getData($u_id)
    {

        $this->db->select("c.id,c.g_id,c.num,c.price,c.goods_selects,c.goods_selects_text,goods.name,goods.img");
    	$this->db->where("u_id",$u_id);
        $this->db->from('cart as c');
        $this->db->join('goods', 'goods.id = c.g_id');
 
        $query = $this->db->get();
		//$query = $this->db->get("cart");
		$result = array();
		foreach ($query->result() as $row)
		{
			$result[] = array('id' => $row->id,'g_id' => $row->g_id,'name' => $row->name,'img' => $row->img,'num' => $row->num,'price' => $row->price,'goods_selects' => $row->goods_selects,'goods_selects_text' => $row->goods_selects_text ); 
		    
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
}