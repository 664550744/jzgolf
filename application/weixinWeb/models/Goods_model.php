<?php 

class Goods_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
	
    public function get_json_list($num=10,$page=0,$where = array())
    {
        

        $this->db->select('id,name,img,online,price_market,price,stock_num');
        $this->db->limit($num, $page*$num);
        
        $query = $this->db->get_where('goods',$where);
        $result=array();
        foreach ($query->result() as $key => $value) {
            # code...
             $result[]= array(
                'id' =>$value->id ,
                'name' =>$value->name , 
                'online' =>$value->online , 
                'price_market' =>$value->price_market , 
                'price' =>$value->price , 
                'img' =>$value->img , 
                'stock_num' =>$value->stock_num   );
        }
        
        return $result;
    }
    /**
     * @Author    wwh
     * @DateTime  2018-08-24
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @param     integer
     * @return    [type]
     */
    public function get_goods($id=0)
    {
        $this->db->select('goods.id,goods.name,goods.price,goods.is_new,goods.stock_num,goods.stock_num_info,goods_detail.imgs,goods_detail.goods_attribute,goods_detail.goods_select,goods_brand.text as brand');
        $this->db->from('goods');
        $this->db->join('goods_detail', 'goods_detail.goods_id = goods.id');
        $this->db->join('goods_brand', 'goods_brand.id = goods.brand_id');
         $this->db->where("goods.id",$id); 
        
        $query = $this->db->get();
        $result =array();
        foreach ($query->result() as $row)
        {
            $result["name"]=$row->name;
            $result["id"]=$row->id;
            $result["price"]=$row->price;
            $result["brand"]=$row->brand;
            $result["stock_num"]=$row->stock_num;
            $result["is_new"]=$row->is_new;
            $result["imgs"]=json_decode($row->imgs,1);
            $result["goods_select"]=json_decode($row->goods_select,1);
            $result["goods_attribute"]=json_decode($row->goods_attribute,1);
            $result["stock_num_info"]=json_decode($row->stock_num_info,1);
            
            
        }
        return $result;

    }
    public function get_content($id=0){
        $this->db->select("goods_content");
        $query = $this->db->get_where("goods_detail",array('goods_id' => $id)); 
        $html ="";
        foreach ($query->result() as $row)
        {
            $html = $row->goods_content;
        }
        
        
        return  $html;
    }

    
	
}
?>
