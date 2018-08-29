<?php 

class Goods_attribute_option_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
	public function get_data($b_uid,$type=0)
    {
		$this->db->select('t.id as id,t.pid as pid,t.text as text,t.order_value as order_value,p.text as p_text');
		$this->db->from('goods_attribute as p');
		$this->db->join('goods_attribute_option as t', 'p.id = t.pid');
		if($type==0){
			$this->db->where('p.b_uid', $b_uid);
		}else{
			$this->db->where('t.id', $b_uid);
		}
		
		$query = $this->db->get();
        //$query = $this->db->get_where('goods_attribute_option',$where);
        return $query->result();
    }
	public function add($data)
    {
		 $r= $this->db->insert('goods_attribute_option', $data);
		 if($r){
			return array('code'=>1,'msg'=>'添加成功！');
		}else{
			return array('code'=>0,'msg'=>'添加失败！');
		}
        
    }
	public function update($data,$where)
    {
       $r = $this->db->update('goods_attribute_option', $data, $where);
        if($r){
			return array('code'=>1,'msg'=>'修改成功！');
		}else{
			return array('code'=>0,'msg'=>'修改失败！');
		}
    }
	public function del($id)
    {

		$r = $this->db->delete('goods_attribute_option', array('id' => $id));
		if($r){
			return array('code'=>1,'msg'=>'删除成功！');
		}else{
			return array('code'=>0,'msg'=>'删除失败！');
		}

    }
	
}
?>
