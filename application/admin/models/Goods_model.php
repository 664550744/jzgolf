<?php 

class Goods_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
	public function get_data($id)
    {
    	$this->db->select('*');
		$this->db->from('goods');
		$this->db->join('goods_detail', 'goods_detail.goods_id = goods.id');
        $this->db->where("goods.id",$id);
    	
    	$query = $this->db->get();
    	$result =array();
        foreach ($query->result() as $row)
        {
            $result["name"]=$row->name;
            $result["num_code"]=$row->num_code;
            $result["price_market"]=$row->price_market;
            $result["price"]=$row->price;
            $result["online"]=$row->online;
            $result["category_id"]=$row->category_id;
            $result["brand_id"]=$row->brand_id;
            $result["stock_num"]=$row->stock_num;
            $result["is_new"]=$row->is_new;
            $result["sort"]=$row->sort;
            $result["goods_content"]=$row->goods_content;
            $result["imgs"]=json_decode($row->imgs,1);
            $result["goods_select"]=json_decode($row->goods_select,1);
            $result["goods_attribute"]=json_decode($row->goods_attribute,1);
            $result["stock_num_info"]=json_decode($row->stock_num_info,1);
            
            
    	}
        return $result;
    }
    public function get_json_list($b_uid=0,$num=10,$page=0)
    {
        

        $this->db->select('id,name,img,sort,online,addtime');
        if($b_uid!=0){
            $this->db->where("b_uid",$b_uid);
        }
        $this->db->limit($num, $page*$num);
        
        $query = $this->db->get('goods');
        $count_all =$this->db->count_all('goods');
        
        
        return $arrayName = array('data' => $query->result(),'count_all'=>$count_all );
    }

    public function add($data,$detail)
    {
        $id=0;
        $this->db->trans_start();
        $r  = $this->db->insert('goods', $data);
        $id = $this->db->insert_id();
        $detail['goods_id'] =$id;
        $this->db->insert('goods_detail', $detail);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            return array('code'=>0,'msg'=>'添加失败！');    
        }
         
        if($r){
            return array('code'=>1,'msg'=>'添加成功','id'=>$id);
        }else{
            return array('code'=>0,'msg'=>'添加失败！');
        }
        
    }
    public function update($data,$id,$detail)
    {
        $this->db->trans_start();
        $r = $this->db->update('goods', $data, array('id' => $id ));
         $this->db->update('goods_detail', $detail, array('goods_id' => $id ));
        $this->db->trans_complete();
       $r = $this->db->update('goods', $data, array('id' => $id ));
        if ($this->db->trans_status() === FALSE)
        {
            return array('code'=>0,'msg'=>'修改失败！');    
        }
        if($r){
            return array('code'=>1,'msg'=>'修改成功！');
        }else{
            return array('code'=>0,'msg'=>'修改失败！');
        }
    }
    public function del($id)
    {
        $r = $this->db->delete('goods', array('id' => $id));
        if($r){
            return array('code'=>1,'msg'=>'删除成功！');
        }else{
            return array('code'=>0,'msg'=>'删除失败！');
        }

    }

    public function img($data,$where)
    {
       $r = $this->db->update('goods', $data, $where);
        return $r;
    }
	
	
}
?>
