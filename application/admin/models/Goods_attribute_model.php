<?php 

class Goods_attribute_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
	public function get_data($where)
    {
        $query = $this->db->get_where('goods_attribute',$where);
        return $query->result();
    }
	public function add($data)
    {
		 $r= $this->db->insert('goods_attribute', $data);
		 if($r){
			return array('code'=>1,'msg'=>'添加成功！');
		}else{
			return array('code'=>0,'msg'=>'添加失败！');
		}
        
    }
	public function update($data,$where)
    {
       $r = $this->db->update('goods_attribute', $data, $where);
        if($r){
			return array('code'=>1,'msg'=>'修改成功！');
		}else{
			return array('code'=>0,'msg'=>'修改失败！');
		}
    }
	public function del($id)
    {
		$this->db->trans_start();
		$this->db->query('DELETE FROM `goods_attribute` WHERE `goods_attribute`.`id` = '.$id.';');
		$this->db->query('DELETE FROM `goods_attribute_option` WHERE `goods_attribute_option`.`pid` = '.$id.';');
		$this->db->trans_complete();
	
		$r =$this->db->trans_status();
		if($r){
			return array('code'=>1,'msg'=>'删除成功！');
		}else{
			return array('code'=>0,'msg'=>'删除失败！');
		}

    }
	
}
?>
