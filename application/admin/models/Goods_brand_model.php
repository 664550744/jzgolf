<?php 

class Goods_brand_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
	public function get_data($where)
    {
    	
    		$query = $this->db->get_where('goods_brand', $where);
    	
    	
        return $query->result();
    }
	public function add($data)
    {
		 $r= $this->db->insert('goods_brand', $data);
		 if($r){
			return array('code'=>1,'msg'=>'添加成功！');
		}else{
			return array('code'=>0,'msg'=>'添加失败！');
		}
        
    }
	public function update($data,$where)
    {
       $r = $this->db->update('goods_brand', $data, $where);
        if($r){
			return array('code'=>1,'msg'=>'修改成功！');
		}else{
			return array('code'=>0,'msg'=>'修改失败！');
		}
    }
	public function del($id)
    {
		$r = $this->db->delete('goods_brand', array('id' => $id));
		if($r){
			return array('code'=>1,'msg'=>'删除成功！');
		}else{
			return array('code'=>0,'msg'=>'删除失败！');
		}

    }
	
}
?>
