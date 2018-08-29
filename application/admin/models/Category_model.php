<?php 

class Category_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
	public function get_data()
    {
        $query = $this->db->get_where('category');
        return $query->result();
    }
	public function add($data)
    {
		 $r= $this->db->insert('category', $data);
		 if($r){
			return array('code'=>1,'msg'=>'添加成功！');
		}else{
			return array('code'=>0,'msg'=>'添加失败！');
		}
        
    }
	public function update($data,$where)
    {
       $r = $this->db->update('category', $data, $where);
        if($r){
			return array('code'=>1,'msg'=>'修改成功！');
		}else{
			return array('code'=>0,'msg'=>'修改失败！');
		}
    }
	public function del($id)
    {
       
		$this->db->trans_start();
		$this->db->query('DELETE FROM `category` WHERE `category`.`id` = '.$id.';');
		$this->db->query('DELETE FROM `category` WHERE `category`.`pid` = '.$id.';');
		$this->db->trans_complete();
		return $this->db->trans_status();

    }
	
}
?>
